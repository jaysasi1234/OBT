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
        | Do NOT allow Eloquent/Carbon serialization to convert these
        | date-only database values into UTC timestamps.
        |
        | getRawOriginal() returns the EXACT value stored in MySQL.
        |
        */

        $dateDeployed =
            $deployment->getRawOriginal('date_deployed');

        $dateDisembarked =
            $deployment->getRawOriginal('date_disembarked');


        /*
        |--------------------------------------------------------------------------
        | Normalize the raw values to YYYY-MM-DD only
        |--------------------------------------------------------------------------
        */

        if ($dateDeployed) {

            $dateDeployed = substr(
                (string) $dateDeployed,
                0,
                10
            );

        } else {

            $dateDeployed = null;
        }


        if ($dateDisembarked) {

            $dateDisembarked = substr(
                (string) $dateDisembarked,
                0,
                10
            );

        } else {

            $dateDisembarked = null;
        }


        /*
        |--------------------------------------------------------------------------
        | Return only the fields needed by the modal
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'deployment' => [

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

                'date_deployed' =>
                    $dateDeployed,

                'disembarkation_place' =>
                    $deployment->disembarkation_place,

                'date_disembarked' =>
                    $dateDisembarked,

                'status' =>
                    $deployment->status,

                'percentage' =>
                    (int) ($deployment->percentage ?? 0),
            ]

        ]);
    }


    // =========================
    // UPDATE DEPLOYMENT
    // =========================
    public function update(Request $request, Cadet $cadet)
    {
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
                    'nullable|date_format:Y-m-d',

                'disembarkation_place' =>
                    'nullable|string|max:255',

                'date_disembarked' =>
                    'nullable|date_format:Y-m-d',

            ]);


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

            $deployment = Deployment::firstOrNew([
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
            | IMPORTANT DATE FIX
            |--------------------------------------------------------------------------
            |
            | Store the date input directly as YYYY-MM-DD.
            |
            | Do NOT use Carbon here.
            | Do NOT use ->toISOString().
            | Do NOT use ->format() on a converted date.
            |
            */

            $deployment->date_deployed =
                !empty($validated['date_deployed'])
                    ? $validated['date_deployed']
                    : null;


            $deployment->disembarkation_place =
                $validated['disembarkation_place'] ?? null;


            $deployment->date_disembarked =
                !empty($validated['date_disembarked'])
                    ? $validated['date_disembarked']
                    : null;


            $deployment->save();


            // =========================
            // AUTO ASSIGN REQUIREMENTS
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


                foreach ($requirements as $requirement) {

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

            if ($status === 'Completed') {

                $cadet->bs_status =
                    'Qualified';

            } else {

                $cadet->bs_status =
                    'Not Qualified';
            }


            $cadet->save();


            // =========================
            // RESPONSE
            // =========================

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