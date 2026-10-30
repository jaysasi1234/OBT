<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Batch;
use App\Models\Document;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Display verification monitoring with pagination.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL SYSTEM REQUIREMENTS
        |--------------------------------------------------------------------------
        */

        $totalRequirements = Document::count();

        /*
        |--------------------------------------------------------------------------
        | LOAD CADETS
        |--------------------------------------------------------------------------
        */

        $query = Cadet::with([
            'user',
            'batch',
            'documents',
            'bsRequirements',
        ]);

        /*
        |--------------------------------------------------------------------------
        | SEARCH FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('trb_control_number', 'like', "%{$search}%");

            });
        }

        /*
        |--------------------------------------------------------------------------
        | COURSE FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('course')) {

            $query->where(
                'course',
                $request->course
            );
        }

        /*
        |--------------------------------------------------------------------------
        | BATCH FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('batch')) {

            $query->where(
                'batch_id',
                $request->batch
            );
        }

        /*
        |--------------------------------------------------------------------------
        | GET MATCHING CADET RECORDS
        |--------------------------------------------------------------------------
        */

        $allCadets = $query
            ->orderBy('full_name', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | CALCULATE REQUIREMENT STATUS
        |--------------------------------------------------------------------------
        */

        foreach ($allCadets as $cadet) {

            /*
            | DOCUMENT REQUIREMENTS
            */

            $approvedDocuments = $cadet->documents
                ->where('pivot.status', 'Approved')
                ->count();

            $cadet->required_documents_count =
                $totalRequirements;

            $cadet->approved_documents_count =
                $approvedDocuments;

            $cadet->doc_progress =
                $totalRequirements > 0
                    ? $approvedDocuments . '/' . $totalRequirements
                    : '0/0';

            /*
            | VERIFICATION STATUS
            */

            $cadet->verification_status =
                (
                    $totalRequirements > 0 &&
                    $approvedDocuments >= $totalRequirements
                )
                    ? 'Verified'
                    : 'Pending';

            /*
            | BS REQUIREMENTS
            */

            $totalBSRequirements =
                $cadet->bsRequirements->count();

            $completedBSRequirements =
                $cadet->bsRequirements
                    ->whereIn('status', [
                        'Approved',
                        'Completed',
                    ])
                    ->count();

            $cadet->bs_required_count =
                $totalBSRequirements;

            $cadet->bs_completed_count =
                $completedBSRequirements;

            /*
            | BS STATUS
            */

            $cadet->bs_status =
                (
                    $totalBSRequirements > 0 &&
                    $completedBSRequirements >= $totalBSRequirements
                )
                    ? 'Qualified'
                    : 'Not Qualified';
        }

        /*
        |--------------------------------------------------------------------------
        | VERIFICATION STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('verification_status')) {

            $allCadets = $allCadets
                ->filter(function ($cadet) use ($request) {

                    return $cadet->verification_status ===
                        $request->verification_status;

                });
        }

        /*
        |--------------------------------------------------------------------------
        | BS STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('bs_status')) {

            $allCadets = $allCadets
                ->filter(function ($cadet) use ($request) {

                    return $cadet->bs_status ===
                        $request->bs_status;

                });
        }

        /*
        |--------------------------------------------------------------------------
        | STATISTICS
        | BASED ON ALL FILTERED RECORDS
        |--------------------------------------------------------------------------
        */

        $verificationTotal = $allCadets->count();

        $completed = $allCadets
            ->where('verification_status', 'Verified')
            ->count();

        $incomplete = $allCadets
            ->where('verification_status', 'Pending')
            ->count();

        $qualified = $allCadets
            ->where('bs_status', 'Qualified')
            ->count();

        $notQualified = $allCadets
            ->where('bs_status', 'Not Qualified')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $perPage = 25;

        $currentPage = max(
            1,
            $request->integer('page', 1)
        );

        $totalCadets = $allCadets->count();

        $cadets = new \Illuminate\Pagination\LengthAwarePaginator(
            $allCadets
                ->forPage($currentPage, $perPage)
                ->values(),
            $totalCadets,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | COURSES
        |--------------------------------------------------------------------------
        */

        $courses = Cadet::select('course')
            ->whereNotNull('course')
            ->where('course', '!=', '')
            ->distinct()
            ->orderBy('course')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | BATCHES
        |--------------------------------------------------------------------------
        */

        $batches = Batch::orderBy(
            'batch_year',
            'desc'
        )->get();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'superadmin.verification.index',
            compact(
                'cadets',
                'verificationTotal',
                'completed',
                'incomplete',
                'qualified',
                'notQualified',
                'courses',
                'batches'
            )
        );
    }


    /**
     * Display a single cadet verification record.
     */
    public function show(int $id)
    {
        $cadet = Cadet::with([
            'user',
            'batch',
            'documents',
            'bsRequirements',
        ])->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | DOCUMENT VERIFICATION
        |--------------------------------------------------------------------------
        */

        $totalDocs = $cadet->documents->count();

        $approvedDocs = $cadet->documents
            ->where('pivot.status', 'Approved')
            ->count();

        $progress = $totalDocs > 0
            ? round(($approvedDocs / $totalDocs) * 100)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | BS REQUIREMENTS
        |--------------------------------------------------------------------------
        */

        $totalBS = $cadet->bsRequirements->count();

        $completedBS = $cadet->bsRequirements
            ->whereIn('status', [
                'Approved',
                'Completed',
            ])
            ->count();

        /*
        |--------------------------------------------------------------------------
        | BS STATUS
        |--------------------------------------------------------------------------
        */

        $bsStatus = (
            $totalBS > 0 &&
            $completedBS >= $totalBS
        )
            ? 'Qualified'
            : 'Not Qualified';

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'superadmin.verification.show',
            compact(
                'cadet',
                'totalDocs',
                'approvedDocs',
                'progress',
                'totalBS',
                'completedBS',
                'bsStatus'
            )
        );
    }
}
