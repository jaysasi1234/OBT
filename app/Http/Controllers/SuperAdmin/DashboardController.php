<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Complaint;
use App\Models\Deployment;
use App\Models\Document;
use App\Models\Batch;

class DashboardController extends Controller
{
    public function index()
    {
        // =========================
        // BS QUALIFIED
        // =========================

        $bsCompleted = Cadet::with('bsRequirements')
            ->get()
            ->filter(function ($cadet) {

                $totalBS = $cadet->bsRequirements->count();

                $completedBS = $cadet->bsRequirements
                    ->whereIn('status', ['Approved', 'Completed'])
                    ->count();

                return $totalBS > 0 && $completedBS == $totalBS;
            })
            ->count();


        // =========================
        // CADET COUNTS
        // =========================

        $totalCadets = Cadet::count();

        $totalDeployed = Deployment::where('status', 'Ongoing')->count();

        $totalCompleted = Deployment::where('status', 'Completed')->count();


        $notDeployed = Cadet::where(function ($query) {

            $query->doesntHave('deployment')
                ->orWhereHas('deployment', function ($q) {
                    $q->where('status', 'Not Deployed');
                });

        })->count();


        // =========================
        // VERIFICATION COUNTS
        // SAME LOGIC AS ADMIN
        // =========================

        $totalRequirements = Document::count();

        $verified = 0;
        $pendingVerification = 0;

        $verificationCadets = Cadet::with('documents')->get();

        foreach ($verificationCadets as $cadet) {

            $approvedDocuments = $cadet->documents
                ->where('pivot.status', 'Approved')
                ->count();

            if (
                $totalRequirements > 0 &&
                $approvedDocuments == $totalRequirements
            ) {
                $verified++;
            } else {
                $pendingVerification++;
            }
        }

        $deficiency = 0;


        // =========================
        // COMPLAINTS
        // =========================

        $openComplaints = Complaint::where('status', 'Open')->count();

        $resolvedComplaints = Complaint::where('status', 'Resolved')->count();


        // =========================
        // INCOMPLETE REQUIREMENTS
        // =========================

        $incompleteRequirements = Cadet::with('documents')
            ->get()
            ->filter(function ($cadet) use ($totalRequirements) {

                $approvedDocuments = $cadet->documents
                    ->where('pivot.status', 'Approved')
                    ->count();

                return $approvedDocuments < $totalRequirements;
            })
            ->take(5);


        // =========================
        // OVERALL DEPLOYMENT %
        // =========================

        $deploymentPercentage = $totalCadets > 0
            ? round(
                (($totalDeployed + $totalCompleted) / $totalCadets) * 100
            )
            : 0;


        // =========================
        // DYNAMIC COURSE DEPLOYMENT
        // =========================

        $courseDeployment = [];

        $courses = Cadet::select('course')
            ->whereNotNull('course')
            ->where('course', '!=', '')
            ->distinct()
            ->get();

        foreach ($courses as $course) {

            $courseName = $course->course;

            $totalCourseCadets = Cadet::where('course', $courseName)
                ->orWhere('course', 'LIKE', "%$courseName%")
                ->count();

            $deployedCourseCadets = Cadet::where(function ($q) use ($courseName) {

                    $q->where('course', $courseName)
                        ->orWhere('course', 'LIKE', "%$courseName%");

                })
                ->whereHas('deployment', function ($q) {

                    $q->whereIn('status', ['Ongoing', 'Completed']);

                })
                ->count();

            $percentage = $totalCourseCadets > 0
                ? round(
                    ($deployedCourseCadets / $totalCourseCadets) * 100
                )
                : 0;

            $courseDeployment[] = [
                'course' => $courseName,
                'total' => $totalCourseCadets,
                'deployed' => $deployedCourseCadets,
                'percentage' => $percentage,
            ];
        }


        // =========================
        // BATCH DEPLOYMENT SUMMARY
        // =========================

        $batchLabels = [];
        $batchTotals = [];
        $batchDeployed = [];
        $batchPercentages = [];

        $batches = Batch::orderBy('batch_year')->get();

        foreach ($batches as $batch) {

            $total = Cadet::where('batch_id', $batch->id)->count();

            $deployed = Cadet::where('batch_id', $batch->id)
                ->whereHas('deployment', function ($q) {
                    $q->whereIn('status', ['Ongoing', 'Completed']);
                })
                ->count();

            $percentage = $total > 0
                ? round(($deployed / $total) * 100)
                : 0;

            $batchLabels[] = $batch->batch_year;
            $batchTotals[] = $total;
            $batchDeployed[] = $deployed;
            $batchPercentages[] = $percentage;
        }


        // =========================
        // RETURN VIEW
        // =========================

        return view('superadmin.dashboard', [

            'totalCadets' => $totalCadets,

            'totalDeployed' => $totalDeployed,
            'totalCompleted' => $totalCompleted,
            'notDeployed' => $notDeployed,

            'pendingVerification' => $pendingVerification,
            'verified' => $verified,
            'deficiency' => $deficiency,

            'completeVerification' => $verified,
            'incompleteVerification' => $pendingVerification + $deficiency,

            'withComplaints' => $openComplaints,
            'resolvedComplaints' => $resolvedComplaints,

            'incompleteRequirements' => $incompleteRequirements,

            'deploymentPercentage' => $deploymentPercentage,
            'courseDeployment' => $courseDeployment,

            'batchLabels' => $batchLabels,
            'batchTotals' => $batchTotals,
            'batchDeployed' => $batchDeployed,
            'batchPercentages' => $batchPercentages,

            'bsCompleted' => $bsCompleted,
        ]);
    }
}