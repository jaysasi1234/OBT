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
     * Display verification monitoring using optimized database pagination.
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
        | BASE QUERY
        |--------------------------------------------------------------------------
        | Only load the relationships needed by the current page.
        | Requirement counts are calculated by SQL, not PHP collections.
        */

        $query = Cadet::query()
            ->with([
                'user',
                'batch',
            ])
            ->withCount([
                'documents as approved_documents_count' => function ($q) {
                    $q->where('cadet_documents.status', 'Approved');
                },

                'bsRequirements as bs_required_count',

                'bsRequirements as bs_completed_count' => function ($q) {
                    $q->whereIn('status', [
                        'Approved',
                        'Completed',
                    ]);
                },
            ]);

        /*
        |--------------------------------------------------------------------------
        | SEARCH FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = trim($request->search);

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
            $query->where('course', $request->course);
        }

        /*
        |--------------------------------------------------------------------------
        | BATCH FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('batch')) {
            $query->where('batch_id', $request->batch);
        }

        /*
        |--------------------------------------------------------------------------
        | VERIFICATION STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->verification_status === 'Verified') {

            if ($totalRequirements > 0) {
                $query->whereRaw(
                    '(
                        SELECT COUNT(*)
                        FROM cadet_documents
                        WHERE cadet_documents.cadet_id = cadets.id
                        AND cadet_documents.status = ?
                    ) >= ?',
                    ['Approved', $totalRequirements]
                );
            } else {
                // No system requirements means no cadet is Verified.
                $query->whereRaw('1 = 0');
            }

        } elseif ($request->verification_status === 'Pending') {

            if ($totalRequirements > 0) {
                $query->whereRaw(
                    '(
                        SELECT COUNT(*)
                        FROM cadet_documents
                        WHERE cadet_documents.cadet_id = cadets.id
                        AND cadet_documents.status = ?
                    ) < ?',
                    ['Approved', $totalRequirements]
                );
            }

            // If there are zero requirements, every cadet is Pending.
        }

        /*
        |--------------------------------------------------------------------------
        | BS STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->bs_status === 'Qualified') {

            $query
                ->whereHas('bsRequirements')
                ->whereDoesntHave('bsRequirements', function ($q) {
                    $q->whereNotIn('status', [
                        'Approved',
                        'Completed',
                    ]);
                });

        } elseif ($request->bs_status === 'Not Qualified') {

            $query->where(function ($q) {

                // No BS submissions yet.
                $q->whereDoesntHave('bsRequirements')

                    // Or at least one BS requirement is not completed.
                    ->orWhereHas('bsRequirements', function ($subQuery) {
                        $subQuery->whereNotIn('status', [
                            'Approved',
                            'Completed',
                        ]);
                    });

            });
        }

        /*
        |--------------------------------------------------------------------------
        | STATISTICS
        |--------------------------------------------------------------------------
        | These statistics use the same active filters as the records table.
        | They are calculated by the database without loading all cadets.
        */

        $verificationTotal = (clone $query)->count();

        if ($totalRequirements > 0) {

            $completed = (clone $query)
                ->whereRaw(
                    '(
                        SELECT COUNT(*)
                        FROM cadet_documents
                        WHERE cadet_documents.cadet_id = cadets.id
                        AND cadet_documents.status = ?
                    ) >= ?',
                    ['Approved', $totalRequirements]
                )
                ->count();

        } else {
            $completed = 0;
        }

        $incomplete = $verificationTotal - $completed;

        $qualified = (clone $query)
            ->whereHas('bsRequirements')
            ->whereDoesntHave('bsRequirements', function ($q) {
                $q->whereNotIn('status', [
                    'Approved',
                    'Completed',
                ]);
            })
            ->count();

        $notQualified = $verificationTotal - $qualified;

        /*
        |--------------------------------------------------------------------------
        | DATABASE PAGINATION
        |--------------------------------------------------------------------------
        | Only 25 cadets are retrieved for the current page.
        */

        $cadets = $query
            ->orderBy('full_name', 'asc')
            ->paginate(25)
            ->withQueryString();

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

        $batches = Batch::orderBy('batch_year', 'desc')->get();

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
                'batches',
                'totalRequirements'
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

        $bsStatus = (
            $totalBS > 0 &&
            $completedBS >= $totalBS
        )
            ? 'Qualified'
            : 'Not Qualified';

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
