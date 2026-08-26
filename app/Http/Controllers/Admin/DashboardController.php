<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Complaint;
use App\Models\Deployment;
use App\Models\Batch;
use App\Models\Document;

class DashboardController extends Controller
{
    /**
     * =========================================================
     * ADMIN DASHBOARD
     * OPTIMIZED VERSION
     * =========================================================
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC COUNTS
        |--------------------------------------------------------------------------
        */

        $totalCadets = Cadet::count();

        $totalRequirements = Document::count();

        $totalDeployed = Deployment::where('status', 'Ongoing')->count();

        $totalCompleted = Deployment::where('status', 'Completed')->count();


        /*
        |--------------------------------------------------------------------------
        | NOT DEPLOYED
        |--------------------------------------------------------------------------
        */

        $notDeployed = Cadet::whereDoesntHave('deployment')
            ->orWhereHas('deployment', function ($query) {
                $query->where('status', 'Not Deployed');
            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | OVERALL DEPLOYMENT PERCENTAGE
        |--------------------------------------------------------------------------
        */

        $deploymentPercentage = $totalCadets > 0
            ? round(
                (($totalDeployed + $totalCompleted) / $totalCadets) * 100
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | COMPLAINTS
        |--------------------------------------------------------------------------
        */

        $openComplaints = Complaint::where('status', 'Open')->count();

        $resolvedComplaints = Complaint::where('status', 'Resolved')->count();


        /*
        |--------------------------------------------------------------------------
        | VERIFICATION
        |--------------------------------------------------------------------------
        |
        | Count approved documents per cadet.
        |
        | IMPORTANT:
        | We do not use partition()->first/second here.
        |
        */

        if ($totalRequirements > 0) {

            $verificationCadets = Cadet::query()
                ->withCount([
                    'documents as approved_documents_count' => function ($query) {
                        $query->where('status', 'Approved');
                    },
                ])
                ->get(['id']);


            $verified = $verificationCadets
                ->where(
                    'approved_documents_count',
                    '>=',
                    $totalRequirements
                )
                ->count();


            $pendingVerification = $totalCadets - $verified;

        } else {

            $verified = 0;

            $pendingVerification = $totalCadets;
        }


        /*
        |--------------------------------------------------------------------------
        | DEFICIENCY
        |--------------------------------------------------------------------------
        |
        | Currently kept at zero because your existing system
        | does not have a separate deficiency calculation.
        |
        */

        $deficiency = 0;


        /*
        |--------------------------------------------------------------------------
        | INCOMPLETE REQUIREMENTS
        |--------------------------------------------------------------------------
        |
        | Only retrieve cadets whose approved document count is
        | less than the required document count.
        |
        */

        if ($totalRequirements > 0) {

            $incompleteRequirements = Cadet::query()

                ->with([
                    'documents',
                    'batch',
                ])

                ->withCount([
                    'documents as approved_documents_count' => function ($query) {
                        $query->where('status', 'Approved');
                    },
                ])

                ->get()

                ->filter(function ($cadet) use ($totalRequirements) {

                    return $cadet->approved_documents_count
                        < $totalRequirements;

                })

                ->values();

        } else {

            $incompleteRequirements = collect();
        }


        /*
        |--------------------------------------------------------------------------
        | DEPLOYED CADET IDS
        |--------------------------------------------------------------------------
        |
        | Get deployed cadets once.
        |
        | This prevents repeatedly querying deployments while
        | generating course and batch statistics.
        |
        */

        $deployedCadetIds = Deployment::query()
            ->whereIn('status', [
                'Ongoing',
                'Completed',
            ])
            ->whereNotNull('cadet_id')
            ->pluck('cadet_id')
            ->unique();


        /*
        |--------------------------------------------------------------------------
        | COURSE DEPLOYMENT
        |--------------------------------------------------------------------------
        */

        $courseTotals = Cadet::query()
            ->selectRaw('course, COUNT(*) as total')
            ->whereNotNull('course')
            ->where('course', '!=', '')
            ->groupBy('course')
            ->orderBy('course')
            ->get();


        $courseDeployed = Cadet::query()
            ->selectRaw('course, COUNT(*) as deployed')
            ->whereNotNull('course')
            ->where('course', '!=', '')
            ->whereIn('id', $deployedCadetIds)
            ->groupBy('course')
            ->pluck('deployed', 'course');


        $courseDeployment = [];


        foreach ($courseTotals as $course) {

            $courseName = $course->course;

            $total = (int) $course->total;

            $deployed = (int) (
                $courseDeployed[$courseName] ?? 0
            );


            $percentage = $total > 0
                ? round(($deployed / $total) * 100)
                : 0;


            $courseDeployment[] = [

                'course' => $courseName,

                'total' => $total,

                'deployed' => $deployed,

                'percentage' => $percentage,

            ];
        }


        /*
        |--------------------------------------------------------------------------
        | BATCH DEPLOYMENT
        |--------------------------------------------------------------------------
        */

        $batchTotals = Cadet::query()
            ->selectRaw('batch_id, COUNT(*) as total')
            ->whereNotNull('batch_id')
            ->groupBy('batch_id')
            ->pluck('total', 'batch_id');


        $batchDeployed = Cadet::query()
            ->selectRaw('batch_id, COUNT(*) as deployed')
            ->whereNotNull('batch_id')
            ->whereIn('id', $deployedCadetIds)
            ->groupBy('batch_id')
            ->pluck('deployed', 'batch_id');


        $batches = Batch::query()
            ->orderBy('batch_year')
            ->get();


        $batchLabels = [];

        $batchTotalValues = [];

        $batchDeployedValues = [];

        $batchPercentages = [];


        foreach ($batches as $batch) {

            $total = (int) (
                $batchTotals[$batch->id] ?? 0
            );


            $deployed = (int) (
                $batchDeployed[$batch->id] ?? 0
            );


            $percentage = $total > 0
                ? round(($deployed / $total) * 100)
                : 0;


            $batchLabels[] = $batch->batch_year;

            $batchTotalValues[] = $total;

            $batchDeployedValues[] = $deployed;

            $batchPercentages[] = $percentage;
        }


        /*
        |--------------------------------------------------------------------------
        | BS REQUIREMENTS
        |--------------------------------------------------------------------------
        |
        | Count cadets whose BS requirements are all
        | Approved or Completed.
        |
        */

        $bsCompleted = Cadet::query()

            ->withCount('bsRequirements')

            ->withCount([
                'bsRequirements as completed_bs_requirements_count' => function ($query) {

                    $query->whereIn('status', [
                        'Approved',
                        'Completed',
                    ]);

                },
            ])

            ->get(['id'])

            ->filter(function ($cadet) {

                return $cadet->bs_requirements_count > 0

                    && $cadet->completed_bs_requirements_count
                        == $cadet->bs_requirements_count;

            })

            ->count();


        /*
        |--------------------------------------------------------------------------
        | RETURN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard', [

            /*
            |--------------------------------------------------------------------------
            | CADETS
            |--------------------------------------------------------------------------
            */

            'totalCadets' => $totalCadets,

            'totalDeployed' => $totalDeployed,

            'totalCompleted' => $totalCompleted,

            'notDeployed' => $notDeployed,


            /*
            |--------------------------------------------------------------------------
            | VERIFICATION
            |--------------------------------------------------------------------------
            */

            'pendingVerification' => $pendingVerification,

            'verified' => $verified,

            'deficiency' => $deficiency,

            'completeVerification' => $verified,

            'incompleteVerification' =>
                $pendingVerification + $deficiency,


            /*
            |--------------------------------------------------------------------------
            | COMPLAINTS
            |--------------------------------------------------------------------------
            */

            'withComplaints' => $openComplaints,

            'resolvedComplaints' => $resolvedComplaints,


            /*
            |--------------------------------------------------------------------------
            | REQUIREMENTS
            |--------------------------------------------------------------------------
            */

            'incompleteRequirements' =>
                $incompleteRequirements,


            /*
            |--------------------------------------------------------------------------
            | DEPLOYMENT
            |--------------------------------------------------------------------------
            */

            'deploymentPercentage' =>
                $deploymentPercentage,


            /*
            |--------------------------------------------------------------------------
            | COURSE CHART
            |--------------------------------------------------------------------------
            */

            'courseDeployment' =>
                $courseDeployment,


            /*
            |--------------------------------------------------------------------------
            | BATCH CHART
            |--------------------------------------------------------------------------
            */

            'batchLabels' =>
                $batchLabels,

            'batchTotals' =>
                $batchTotalValues,

            'batchDeployed' =>
                $batchDeployedValues,

            'batchPercentages' =>
                $batchPercentages,


            /*
            |--------------------------------------------------------------------------
            | BS REQUIREMENTS
            |--------------------------------------------------------------------------
            */

            'bsCompleted' =>
                $bsCompleted,
        ]);
    }
}