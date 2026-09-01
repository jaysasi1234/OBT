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

    $verified = Cadet::where('verification_status', 'Verified')->count();
    $pending = Cadet::where('verification_status', 'Pending')->count();
    $deficient = Cadet::where('verification_status', 'Deficiency')->count();

    $totalDeployed = $ongoing + $completed;

    $batches = Batch::orderBy('batch_year', 'desc')->get();

    // ✅ ADD THIS LINE
$courses = Cadet::select('course')
    ->distinct()
    ->orderBy('course')
    ->get();

    return view('admin.deployment.index', compact(
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
        'courses' // ✅ IMPORTANT
    ));
}

public function show(Cadet $cadet)
{
    $cadet->load('deployment');

    return response()->json([
        'deployment' => $cadet->deployment
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
                'deployment_status'      => 'required|string',
                'vessel_name'            => 'nullable|string|max:255',
                'company'                => 'nullable|string|max:255',
                'deployment_type'        => 'required|in:Domestic,International',
                'embarkation_place'      => 'nullable|string|max:255',
                'date_deployed'          => 'nullable|date',
                'disembarkation_place'   => 'nullable|string|max:255',
                'date_disembarked'       => 'nullable|date',
            ]);

            // =========================
            // NORMALIZE STATUS (IMPORTANT FIX)
            // =========================
            $status = match ($validated['deployment_status']) {
                'Not Deployed', 'Not Started' => 'Not Deployed',
                'Ongoing' => 'Ongoing',
                'Completed' => 'Completed',
                default => 'Not Deployed'
            };

            // =========================
            // AUTO PROGRESS
            // =========================
            $percent = match ($status) {
                'Not Deployed' => 0,
                'Ongoing' => 50,
                'Completed' => 100,
            };

            // =========================
            // CREATE OR UPDATE DEPLOYMENT
            // =========================
            $deployment = Deployment::firstOrNew([
                'cadet_id' => $cadet->id
            ]);

            $deployment->status = $status;
            $deployment->percentage = $percent;
            $deployment->vessel_name = $validated['vessel_name'] ?? null;
            $deployment->company_name = $validated['company'] ?? null;
            $deployment->deployment_type = $validated['deployment_type'];
            $deployment->embarkation_place = $validated['embarkation_place'] ?? null;
            $deployment->date_deployed = $validated['date_deployed'] ?? null;
            $deployment->disembarkation_place = $validated['disembarkation_place'] ?? null;
            $deployment->date_disembarked = $validated['date_disembarked'] ?? null;

            $deployment->save();

            // Automatically assign onboard requirements
            if (in_array($status, ['Ongoing', 'Completed'])) {

                $requirements = OnboardRequirement::where('is_active', 1)->get();

                foreach ($requirements as $requirement) {

                    CadetOnboardRequirement::firstOrCreate(
                        [
                            'cadet_id' => $cadet->id,
                            'onboard_requirement_id' => $requirement->id,
                        ],
                        [
                            'status' => 'Pending',
                        ]
                    );

                }

            }

            if ($status == 'Completed') {

                $cadet->bs_status = 'Qualified';

            } else {

                $cadet->bs_status = 'Not Qualified';
            }

            $cadet->save();

            return response()->json([
                'success' => true,
                'message' => 'Deployment updated successfully',
                'percent' => $percent,
                'status' => $status
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}