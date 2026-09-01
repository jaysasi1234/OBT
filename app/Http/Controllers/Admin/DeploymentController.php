<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Batch;
use App\Models\Deployment;
use Illuminate\Http\Request;
use App\Models\OnboardRequirement;
use App\Models\CadetOnboardRequirement;

class DeploymentController extends Controller
{
    // =========================
    // INDEX
    // =========================
    public function index()
    {
        $cadets = Cadet::with(['batch', 'deployment'])
            ->select(
                'id',
                'trb_control_number',
                'full_name',
                'course',
                'batch_id',
                'verification_status',
                'photo'
            )
            ->orderBy('full_name')
            ->get();

        $stats = Deployment::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'Ongoing' THEN 1 ELSE 0 END) as ongoing,
            SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed,
            SUM(CASE WHEN status = 'Not Deployed' THEN 1 ELSE 0 END) as not_deployed
        ")->first();

        $totalCadets = $stats->total ?? 0;
        $ongoing = $stats->ongoing ?? 0;
        $completed = $stats->completed ?? 0;
        $notDeployed = $stats->not_deployed ?? 0;

        $verified = Cadet::where(
            'verification_status',
            'Verified'
        )->count();

        $pending = Cadet::where(
            'verification_status',
            'Pending'
        )->count();

        $deficient = Cadet::where(
            'verification_status',
            'Deficiency'
        )->count();

        $totalDeployed = $ongoing + $completed;

        $batches = Batch::orderBy(
            'batch_year',
            'desc'
        )->get();

        $courses = Cadet::select('course')
            ->distinct()
            ->orderBy('course')
            ->get();

        return view(
            'admin.deployment.index',
            compact(
                'cadets',
                'totalCadets',
                'ongoing',
                'completed',
                'notDeployed',
                'totalDeployed',
                'verified',
                'pending',
                'deficient',
                'batches',
                'courses'
            )
        );
    }


    // =========================
    // SHOW DEPLOYMENT
    // =========================
    public function show(Cadet $cadet)
    {
        $deployment = Deployment::where(
            'cadet_id',
            $cadet->id
        )->first();

        if (!$deployment) {

            return response()->json([
                'deployment' => null
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | IMPORTANT DATE FIX
        |--------------------------------------------------------------------------
        |
        | date_deployed and date_disembarked are CALENDAR DATES.
        |
        | They are NOT timestamps.
        |
        | Do NOT allow Laravel/Carbon JSON serialization to convert them
        | through a timezone.
        |
        | getRawOriginal() retrieves the exact value stored in the database.
        |
        */

        $deploymentData = [

            'id' =>
                $deployment->id,

            'cadet_id' =>
                $deployment->cadet_id,

            'vessel_name' =>
                $deployment->vessel_name,

            'company_name' =>
                $deployment->company_name,

            'deployment_type' =>
                $deployment->deployment_type,

            'embarkation_place' =>
                $deployment->embarkation_place,

            /*
             * EXACT DATABASE VALUE
             *
             * Example:
             * 1999-12-31
             *
             * No Carbon.
             * No timezone conversion.
             */
            'date_deployed' =>
                $this->rawDate(
                    $deployment,
                    'date_deployed'
                ),

            'disembarkation_place' =>
                $deployment->disembarkation_place,

            /*
             * EXACT DATABASE VALUE
             */
            'date_disembarked' =>
                $this->rawDate(
                    $deployment,
                    'date_disembarked'
                ),

            'status' =>
                $deployment->status,

            'percentage' =>
                (int) ($deployment->percentage ?? 0),

        ];


        return response()->json([
            'deployment' => $deploymentData
        ]);
    }


    // =========================
    // RAW DATE HELPER
    // =========================
    private function rawDate(
        Deployment $deployment,
        string $column
    ): ?string {

        /*
        |--------------------------------------------------------------------------
        | Get the ORIGINAL database value.
        |--------------------------------------------------------------------------
        |
        | This bypasses Eloquent's Carbon/date casting.
        |
        | If database contains:
        |
        | 1999-12-31
        |
        | this returns:
        |
        | 1999-12-31
        |
        | and NOT:
        |
        | 2000-01-01T00:00:00...
        |
        */

        $value =
            $deployment->getRawOriginal(
                $column
            );


        if (
            $value === null ||
            $value === ''
        ) {

            return null;

        }


        /*
        |--------------------------------------------------------------------------
        | DATE columns should already be YYYY-MM-DD.
        |
        | If for any reason the database driver returns a longer value,
        | keep only the date portion.
        |--------------------------------------------------------------------------
        */

        return substr(
            (string) $value,
            0,
            10
        );
    }


    // =========================
    // UPDATE DEPLOYMENT
    // =========================
    public function update(
        Request $request,
        Cadet $cadet
    ) {

        try {

            // =========================
            // VALIDATION
            // =========================
            $validated = $request->validate([

                'deployment_status' =>
                    'required|string',

                'vessel_name' =>
                    'nullable|string|max:255',

                'company' =>
                    'nullable|string|max:255',

                'deployment_type' =>
                    'required|in:Domestic,International',

                'embarkation_place' =>
                    'nullable|string|max:255',

                'date_deployed' =>
                    'nullable|date',

                'disembarkation_place' =>
                    'nullable|string|max:255',

                'date_disembarked' =>
                    'nullable|date',

            ]);


            // =========================
            // VALIDATE DATE ORDER
            // =========================
            if (
                !empty($validated['date_deployed']) &&
                !empty($validated['date_disembarked'])
            ) {

                $embarkation =
                    $validated['date_deployed'];

                $disembarkation =
                    $validated['date_disembarked'];


                if (
                    $disembarkation <
                    $embarkation
                ) {

                    return response()->json([
                        'success' => false,
                        'message' =>
                            'Disembarkation date cannot be earlier than embarkation date.'
                    ], 422);

                }
            }


            // =========================
            // NORMALIZE STATUS
            // =========================
            $status = match (
                $validated['deployment_status']
            ) {

                'Not Deployed',
                'Not Started'
                    => 'Not Deployed',

                'Ongoing'
                    => 'Ongoing',

                'Completed'
                    => 'Completed',

                default
                    => 'Not Deployed'
            };


            // =========================
            // AUTO PROGRESS
            // =========================
            $percent = match ($status) {

                'Not Deployed'
                    => 0,

                'Ongoing'
                    => 50,

                'Completed'
                    => 100,

            };


            // =========================
            // CREATE / UPDATE
            // =========================
            $deployment =
                Deployment::firstOrNew([
                    'cadet_id' => $cadet->id
                ]);


            $deployment->status =
                $status;

            $deployment->percentage =
                $percent;

            $deployment->vessel_name =
                $validated['vessel_name'] ?? null;

            $deployment->company_name =
                $validated['company'] ?? null;

            $deployment->deployment_type =
                $validated['deployment_type'];

            $deployment->embarkation_place =
                $validated['embarkation_place'] ?? null;


            /*
            |--------------------------------------------------------------------------
            | IMPORTANT
            |--------------------------------------------------------------------------
            |
            | The HTML date input sends:
            |
            | YYYY-MM-DD
            |
            | Keep it exactly as entered.
            |
            | Do NOT use Carbon here.
            |
            */

            $deployment->date_deployed =
                $validated['date_deployed'] ?? null;

            $deployment->disembarkation_place =
                $validated['disembarkation_place'] ?? null;

            $deployment->date_disembarked =
                $validated['date_disembarked'] ?? null;


            $deployment->save();


            // =========================
            // AUTOMATIC REQUIREMENTS
            // =========================
            if (
                in_array(
                    $status,
                    ['Ongoing', 'Completed']
                )
            ) {

                $requirements =
                    OnboardRequirement::where(
                        'is_active',
                        1
                    )->get();


                foreach (
                    $requirements as $requirement
                ) {

                    CadetOnboardRequirement::firstOrCreate(
                        [
                            'cadet_id' =>
                                $cadet->id,

                            'onboard_requirement_id' =>
                                $requirement->id,
                        ],
                        [
                            'status' =>
                                'Pending',
                        ]
                    );
                }
            }


            // =========================
            // BS STATUS
            // =========================
            if (
                $status === 'Completed'
            ) {

                $cadet->bs_status =
                    'Qualified';

            } else {

                $cadet->bs_status =
                    'Not Qualified';
            }


            $cadet->save();


            return response()->json([

                'success' =>
                    true,

                'message' =>
                    'Deployment updated successfully',

                'percent' =>
                    $percent,

                'status' =>
                    $status,

            ]);


        } catch (\Throwable $e) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    $e->getMessage()

            ], 500);
        }
    }
}