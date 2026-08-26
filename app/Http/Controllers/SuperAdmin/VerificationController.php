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
     * Display verification monitoring.
     */
    public function index(Request $request)
    {
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
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $query->where(
                'full_name',
                'like',
                '%' . $request->search . '%'
            );
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
        | GET CADETS
        | A-Z ORDER
        |--------------------------------------------------------------------------
        */

        $cadets = $query
            ->orderBy('full_name', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | TOTAL SYSTEM DOCUMENT REQUIREMENTS
        |--------------------------------------------------------------------------
        */

        $totalRequirements = Document::count();


        /*
        |--------------------------------------------------------------------------
        | CALCULATE VERIFICATION STATUS
        |--------------------------------------------------------------------------
        */

        foreach ($cadets as $cadet) {

            /*
            |----------------------------------------------------------------------
            | DOCUMENT STATUS
            |----------------------------------------------------------------------
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
            |----------------------------------------------------------------------
            | VERIFICATION STATUS
            |----------------------------------------------------------------------
            */

            if (
                $totalRequirements > 0 &&
                $approvedDocuments >= $totalRequirements
            ) {

                $cadet->verification_status = 'Verified';

            } else {

                $cadet->verification_status = 'Pending';
            }


            /*
            |----------------------------------------------------------------------
            | BS REQUIREMENTS
            |----------------------------------------------------------------------
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
            |----------------------------------------------------------------------
            | BS STATUS
            |----------------------------------------------------------------------
            */

            if (
                $totalBSRequirements > 0 &&
                $completedBSRequirements >= $totalBSRequirements
            ) {

                $cadet->bs_status = 'Qualified';

            } else {

                $cadet->bs_status = 'Not Qualified';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | VERIFICATION STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('verification_status')) {

            $cadets = $cadets
                ->filter(function ($cadet) use ($request) {

                    return $cadet->verification_status ===
                        $request->verification_status;

                })
                ->values();
        }


        /*
        |--------------------------------------------------------------------------
        | BS STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('bs_status')) {

            $cadets = $cadets
                ->filter(function ($cadet) use ($request) {

                    return $cadet->bs_status ===
                        $request->bs_status;

                })
                ->values();
        }


        /*
        |--------------------------------------------------------------------------
        | STATISTICS
        |--------------------------------------------------------------------------
        */

        $verificationTotal =
            $cadets->count();

        $completed =
            $cadets
                ->where('verification_status', 'Verified')
                ->count();

        $incomplete =
            $cadets
                ->where('verification_status', 'Pending')
                ->count();

        $qualified =
            $cadets
                ->where('bs_status', 'Qualified')
                ->count();

        $notQualified =
            $cadets
                ->where('bs_status', 'Not Qualified')
                ->count();


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

        $totalDocs =
            $cadet->documents->count();

        $approvedDocs =
            $cadet->documents
                ->where('pivot.status', 'Approved')
                ->count();

        $progress =
            $totalDocs > 0
                ? round(
                    ($approvedDocs / $totalDocs) * 100
                )
                : 0;


        /*
        |--------------------------------------------------------------------------
        | BS REQUIREMENTS
        |--------------------------------------------------------------------------
        */

        $totalBS =
            $cadet->bsRequirements->count();

        $completedBS =
            $cadet->bsRequirements
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

        $bsStatus =
            (
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