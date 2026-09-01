<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Cadet;
use App\Models\CadetOnboardRequirement;
use App\Models\Deployment;
use App\Models\OnboardRequirement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeploymentController extends Controller
{
    /**
     * Display the deployment monitoring page.
     */
    public function index()
    {
        $cadets = Cadet::query()
            ->with([
                'batch',
                'deployment',
            ])
            ->select([
                'id',
                'trb_control_number',
                'full_name',
                'course',
                'batch_id',
                'verification_status',
                'photo',
            ])
            ->orderBy('full_name')
            ->get();

        $stats = Deployment::query()
            ->selectRaw("
                COUNT(*) AS total,
                SUM(CASE WHEN status = 'Ongoing' THEN 1 ELSE 0 END) AS ongoing,
                SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) AS completed,
                SUM(CASE WHEN status = 'Not Deployed' THEN 1 ELSE 0 END) AS not_deployed
            ")
            ->first();

        $ongoing = (int) ($stats->ongoing ?? 0);
        $completed = (int) ($stats->completed ?? 0);
        $notDeployed = (int) ($stats->not_deployed ?? 0);

        $totalCadets = (int) ($stats->total ?? 0);

        /*
         * A cadet is considered deployed when the deployment
         * status is either Ongoing or Completed.
         */
        $totalDeployed = $ongoing + $completed;

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

        $batches = Batch::query()
            ->orderByDesc('batch_year')
            ->get();

        $courses = Cadet::query()
            ->select('course')
            ->whereNotNull('course')
            ->where('course', '!=', '')
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

    /**
     * Return a cadet's deployment information.
     */
    public function show(Cadet $cadet): JsonResponse
    {
        $cadet->load('deployment');

        return response()->json([
            'success' => true,
            'deployment' => $cadet->deployment,
        ]);
    }

    /**
     * Create or update a cadet deployment.
     */
    public function update(
        Request $request,
        Cadet $cadet
    ): JsonResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                'in:Not Deployed,Ongoing,Completed',
            ],

            'vessel_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'deployment_type' => [
                'required',
                'in:Domestic,International',
            ],

            'embarkation_place' => [
                'nullable',
                'string',
                'max:255',
            ],

            'date_deployed' => [
                'nullable',
                'date',
            ],

            'disembarkation_place' => [
                'nullable',
                'string',
                'max:255',
            ],

            'date_disembarked' => [
                'nullable',
                'date',
                'after_or_equal:date_deployed',
            ],
        ]);

        /*
         * Do not allow a disembarkation date without
         * an embarkation date.
         */
        if (
            !empty($validated['date_disembarked']) &&
            empty($validated['date_deployed'])
        ) {
            return response()->json([
                'success' => false,
                'message' =>
                    'An embarkation date is required before entering a disembarkation date.',
            ], 422);
        }

        /*
         * An ongoing deployment should not have a
         * disembarkation date.
         *
         * If the cadet is still onboard, the sea service
         * duration remains unfinalized.
         */
        if (
            $validated['status'] === 'Ongoing' &&
            !empty($validated['date_disembarked'])
        ) {
            return response()->json([
                'success' => false,
                'message' =>
                    'An ongoing deployment cannot have a disembarkation date.',
            ], 422);
        }

        /*
         * A completed deployment should have both dates.
         */
        if (
            $validated['status'] === 'Completed' &&
            (
                empty($validated['date_deployed']) ||
                empty($validated['date_disembarked'])
            )
        ) {
            return response()->json([
                'success' => false,
                'message' =>
                    'A completed deployment requires both embarkation and disembarkation dates.',
            ], 422);
        }

        /*
         * Automatically determine training progress
         * from the deployment status.
         */
        $percentage = match ($validated['status']) {
            'Not Deployed' => 0,
            'Ongoing' => 50,
            'Completed' => 100,
        };

        try {
            DB::transaction(function () use (
                $validated,
                $percentage,
                $cadet
            ) {
                /*
                 * Create the deployment if it does not exist,
                 * otherwise update the existing record.
                 */
                $deployment = Deployment::firstOrNew([
                    'cadet_id' => $cadet->id,
                ]);

                $deployment->fill([
                    'status' => $validated['status'],
                    'percentage' => $percentage,
                    'vessel_name' => $validated['vessel_name'] ?? null,
                    'company_name' => $validated['company_name'] ?? null,
                    'deployment_type' => $validated['deployment_type'],
                    'embarkation_place' =>
                        $validated['embarkation_place'] ?? null,
                    'date_deployed' =>
                        $validated['date_deployed'] ?? null,
                    'disembarkation_place' =>
                        $validated['disembarkation_place'] ?? null,
                    'date_disembarked' =>
                        $validated['date_disembarked'] ?? null,
                ]);

                $deployment->save();

                /*
                 * Automatically create onboard requirements
                 * when the cadet actually starts training.
                 */
                if (
                    in_array(
                        $validated['status'],
                        ['Ongoing', 'Completed'],
                        true
                    )
                ) {
                    $requirements = OnboardRequirement::query()
                        ->where('is_active', true)
                        ->get();

                    foreach ($requirements as $requirement) {
                        CadetOnboardRequirement::firstOrCreate(
                            [
                                'cadet_id' =>
                                    $cadet->id,

                                'onboard_requirement_id' =>
                                    $requirement->id,
                            ],
                            [
                                'status' => 'Pending',
                            ]
                        );
                    }
                }

                /*
                 * A completed deployment qualifies the cadet.
                 */
                $cadet->update([
                    'bs_status' =>
                        $validated['status'] === 'Completed'
                            ? 'Qualified'
                            : 'Not Qualified',
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Deployment updated successfully.',
                'status' => $validated['status'],
                'percent' => $percentage,
            ]);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' =>
                    'Unable to update the deployment. Please try again.',
            ], 500);
        }
    }
}