<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Complaint;
use App\Models\Deployment;
use App\Models\Batch;
use App\Models\Document;

class DashboardController extends Controller
{
    public function index()
    {
        // =========================================================
        // BS QUALIFIED
        // =========================================================

        $bsCompleted = Cadet::with('bsRequirements')
            ->get()
            ->filter(function ($cadet) {

                $totalBS = $cadet->bsRequirements->count();

                $completedBS = $cadet->bsRequirements
                    ->whereIn('status', [
                        'Approved',
                        'Completed'
                    ])
                    ->count();

                return $totalBS > 0 && $completedBS === $totalBS;
            })
            ->count();


        // =========================================================
        // CADET COUNTS
        // =========================================================

        $totalCadets = Cadet::count();


        // Ongoing deployments
        $totalDeployed = Deployment::where(
            'status',
            'Ongoing'
        )->count();


        // Completed deployments
        $totalCompleted = Deployment::where(
            'status',
            'Completed'
        )->count();


        // =========================================================
        // NOT DEPLOYED
        // =========================================================

        $notDeployed = Cadet::whereDoesntHave('deployment')
            ->orWhereHas('deployment', function ($query) {

                $query->where(
                    'status',
                    'Not Deployed'
                );

            })
            ->count();


        // =========================================================
        // VERIFICATION COUNTS
        // =========================================================
        //
        // Verification is calculated per cadet.
        //
        // Approved = all documents assigned to the cadet
        // are approved.
        //
        // Deficiency = at least one document is rejected.
        //
        // Pending = documents are still waiting for approval.
        //
        // =========================================================

        $verified = 0;

        $pendingVerification = 0;

        $deficiency = 0;


        $verificationCadets = Cadet::with('documents')
            ->get();


// =========================================================
// VERIFICATION COUNTS
// SAME LOGIC AS ADMIN DASHBOARD
// =========================================================

$totalRequirements = Document::count();

$verified = 0;

$pendingVerification = 0;

$deficiency = 0;

if ($totalRequirements > 0) {

    $verificationCadets = Cadet::withCount([
        'documents as approved_documents_count' => function ($query) {

            $query->where('status', 'Approved');

        }
    ])->get(['id']);

    // Count verified cadets
    $verified = $verificationCadets
        ->filter(function ($cadet) use ($totalRequirements) {

            return $cadet->approved_documents_count >= $totalRequirements;

        })
        ->count();

    // Same as Admin Dashboard
    $pendingVerification = $totalCadets - $verified;

    // Same as Admin Dashboard
    $deficiency = 0;

}


        // =========================================================
        // COMPLAINTS
        // =========================================================

        $openComplaints = Complaint::where(
            'status',
            'Open'
        )->count();


        $resolvedComplaints = Complaint::where(
            'status',
            'Resolved'
        )->count();


// =========================================================
// INCOMPLETE REQUIREMENTS
// SAME LOGIC AS ADMIN DASHBOARD
// =========================================================

if ($totalRequirements > 0) {

    $incompleteRequirements = Cadet::with([
        'documents',
        'batch'
    ])
    ->withCount([
        'documents as approved_documents_count' => function ($query) {

            $query->where('status', 'Approved');

        }
    ])
    ->get()
    ->filter(function ($cadet) use ($totalRequirements) {

        return $cadet->approved_documents_count < $totalRequirements;

    })
    ->take(5);

} else {

    $incompleteRequirements = collect();

}


        // =========================================================
        // OVERALL DEPLOYMENT PERCENTAGE
        // =========================================================

        $deploymentPercentage = $totalCadets > 0
            ? round(
                (
                    ($totalDeployed + $totalCompleted)
                    / $totalCadets
                ) * 100
            )
            : 0;


        // Prevent percentage above 100
        $deploymentPercentage = min(
            $deploymentPercentage,
            100
        );


        // =========================================================
        // COURSE DEPLOYMENT
        // =========================================================

        $courseDeployment = [];


        $courses = Cadet::select('course')
            ->whereNotNull('course')
            ->where('course', '!=', '')
            ->distinct()
            ->orderBy('course')
            ->get();


        foreach ($courses as $course) {

            $courseName = $course->course;


            // Total cadets in this course
            $totalCourseCadets = Cadet::where(
                'course',
                $courseName
            )->count();


            // Deployed cadets in this course
            $deployedCourseCadets = Cadet::where(
                'course',
                $courseName
            )
            ->whereHas('deployment', function ($query) {

                $query->whereIn(
                    'status',
                    [
                        'Ongoing',
                        'Completed'
                    ]
                );

            })
            ->count();


            $percentage = $totalCourseCadets > 0
                ? round(
                    (
                        $deployedCourseCadets
                        / $totalCourseCadets
                    ) * 100
                )
                : 0;


            $percentage = min(
                $percentage,
                100
            );


            $courseDeployment[] = [

                'course' => $courseName,

                'total' => $totalCourseCadets,

                'deployed' => $deployedCourseCadets,

                'percentage' => $percentage,

            ];
        }


        // =========================================================
        // BATCH DEPLOYMENT SUMMARY
        // =========================================================

        $batchLabels = [];

        $batchTotals = [];

        $batchDeployed = [];

        $batchPercentages = [];


        $batches = Batch::orderBy(
            'batch_year'
        )->get();


        foreach ($batches as $batch) {

            // Total cadets
            $total = Cadet::where(
                'batch_id',
                $batch->id
            )->count();


            // Ongoing + Completed
            $deployed = Cadet::where(
                'batch_id',
                $batch->id
            )
            ->whereHas('deployment', function ($query) {

                $query->whereIn(
                    'status',
                    [
                        'Ongoing',
                        'Completed'
                    ]
                );

            })
            ->count();


            $percentage = $total > 0
                ? round(
                    ($deployed / $total) * 100
                )
                : 0;


            $percentage = min(
                $percentage,
                100
            );


            // Make sure labels are strings
            $batchLabels[] = (string) $batch->batch_year;


            $batchTotals[] = $total;


            $batchDeployed[] = $deployed;


            $batchPercentages[] = $percentage;
        }


        // =========================================================
        // RETURN DASHBOARD
        // =========================================================

        return view(
            'superadmin.dashboard',
            [

                'totalCadets' =>
                    $totalCadets,

                'totalDeployed' =>
                    $totalDeployed,

                'totalCompleted' =>
                    $totalCompleted,

                'notDeployed' =>
                    $notDeployed,


                'pendingVerification' =>
                    $pendingVerification,

                'verified' =>
                    $verified,

                'deficiency' =>
                    $deficiency,


                'completeVerification' =>
                    $verified,

                'incompleteVerification' =>
                    $pendingVerification + $deficiency,


                'withComplaints' =>
                    $openComplaints,

                'resolvedComplaints' =>
                    $resolvedComplaints,


                'incompleteRequirements' =>
                    $incompleteRequirements,


                'deploymentPercentage' =>
                    $deploymentPercentage,

                'courseDeployment' =>
                    $courseDeployment,


                'batchLabels' =>
                    $batchLabels,

                'batchTotals' =>
                    $batchTotals,

                'batchDeployed' =>
                    $batchDeployed,

                'batchPercentages' =>
                    $batchPercentages,


                'bsCompleted' =>
                    $bsCompleted,

            ]
        );
    }
}