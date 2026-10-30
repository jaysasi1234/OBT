<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Batch;
use App\Models\Document;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index(Request $request)
    {
        $totalRequirements = Document::count();

        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        |--------------------------------------------------------------------------
        */

        $query = Cadet::query()
            ->with('batch')
            ->withCount([
                'documents as approved_documents_count' => function ($q) {
                    $q->wherePivot('status', 'Approved');
                },
                'bsRequirements as bs_required_count',
                'bsRequirements as bs_completed_count' => function ($q) {
                    $q->whereIn('status', ['Approved', 'Completed']);
                },
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
        | VERIFICATION FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('verification_status')) {

            $approvedSql = "(
                SELECT COUNT(*)
                FROM cadet_documents
                WHERE cadet_documents.cadet_id = cadets.id
                AND cadet_documents.status = 'Approved'
            )";

            if ($request->verification_status === 'Verified') {

                if ($totalRequirements > 0) {
                    $query->whereRaw(
                        "{$approvedSql} >= ?",
                        [$totalRequirements]
                    );
                } else {
                    $query->whereRaw('1 = 0');
                }

            } elseif ($request->verification_status === 'Pending') {

                $query->whereRaw(
                    "{$approvedSql} < ?",
                    [$totalRequirements]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | BS STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->bs_status === 'Qualified') {

            $query->whereHas('bsRequirements')
                ->whereDoesntHave('bsRequirements', function ($q) {
                    $q->where(function ($statusQuery) {
                        $statusQuery
                            ->whereNull('status')
                            ->orWhereNotIn('status', [
                                'Approved',
                                'Completed',
                            ]);
                    });
                });

        } elseif ($request->bs_status === 'Not Qualified') {

            $query->where(function ($q) {
                $q->whereDoesntHave('bsRequirements')
                    ->orWhereHas('bsRequirements', function ($bsQuery) {
                        $bsQuery->where(function ($statusQuery) {
                            $statusQuery
                                ->whereNull('status')
                                ->orWhereNotIn('status', [
                                    'Approved',
                                    'Completed',
                                ]);
                        });
                    });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | STATISTICS
        |--------------------------------------------------------------------------
        */

        $verificationTotal = (clone $query)->count();

        $completedQuery = clone $query;

        if ($totalRequirements > 0) {
            $completedQuery->whereRaw(
                "(
                    SELECT COUNT(*)
                    FROM cadet_documents
                    WHERE cadet_documents.cadet_id = cadets.id
                    AND cadet_documents.status = 'Approved'
                ) >= ?",
                [$totalRequirements]
            );
        } else {
            $completedQuery->whereRaw('1 = 0');
        }

        $completed = $completedQuery->count();

        $incompleteQuery = clone $query;

        $incompleteQuery->whereRaw(
            "(
                SELECT COUNT(*)
                FROM cadet_documents
                WHERE cadet_documents.cadet_id = cadets.id
                AND cadet_documents.status = 'Approved'
            ) < ?",
            [$totalRequirements]
        );

        $incomplete = $incompleteQuery->count();

        $qualifiedQuery = clone $query;

        $qualifiedQuery->whereHas('bsRequirements')
            ->whereDoesntHave('bsRequirements', function ($q) {
                $q->where(function ($statusQuery) {
                    $statusQuery
                        ->whereNull('status')
                        ->orWhereNotIn('status', [
                            'Approved',
                            'Completed',
                        ]);
                });
            });

        $qualified = $qualifiedQuery->count();

        $notQualifiedQuery = clone $query;

        $notQualifiedQuery->where(function ($q) {
            $q->whereDoesntHave('bsRequirements')
                ->orWhereHas('bsRequirements', function ($bsQuery) {
                    $bsQuery->where(function ($statusQuery) {
                        $statusQuery
                            ->whereNull('status')
                            ->orWhereNotIn('status', [
                                'Approved',
                                'Completed',
                            ]);
                    });
                });
        });

        $notQualified = $notQualifiedQuery->count();

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $cadets = $query
            ->orderBy('full_name', 'asc')
            ->paginate(25)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | DISPLAY VALUES FOR CURRENT PAGE
        |--------------------------------------------------------------------------
        */

        foreach ($cadets as $cadet) {

            $approved = (int) $cadet->approved_documents_count;

            $cadet->required_documents_count = $totalRequirements;

            $cadet->doc_progress = $totalRequirements > 0
                ? $approved . '/' . $totalRequirements
                : '0/0';

            $cadet->verification_status_display =
                $totalRequirements > 0 &&
                $approved >= $totalRequirements
                    ? 'Verified'
                    : 'Pending';

            $totalBS = (int) $cadet->bs_required_count;
            $completedBS = (int) $cadet->bs_completed_count;

            $cadet->bs_status_display =
                $totalBS > 0 && $completedBS >= $totalBS
                    ? 'Qualified'
                    : 'Not Qualified';
        }

        /*
        |--------------------------------------------------------------------------
        | COURSE OPTIONS
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
        | BATCH OPTIONS
        |--------------------------------------------------------------------------
        */

        $batches = Batch::orderBy('batch_year', 'desc')->get();

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

    public function show(int $id)
    {
        $cadet = Cadet::with([
            'user',
            'batch',
            'documents',
            'bsRequirements',
        ])->findOrFail($id);

        $totalDocs = $cadet->documents->count();

        $approvedDocs = $cadet->documents
            ->where('pivot.status', 'Approved')
            ->count();

        $progress = $totalDocs > 0
            ? round(($approvedDocs / $totalDocs) * 100)
            : 0;

        $totalBS = $cadet->bsRequirements->count();

        $completedBS = $cadet->bsRequirements
            ->whereIn('status', ['Approved', 'Completed'])
            ->count();

        $bsStatus = ($totalBS > 0 && $completedBS >= $totalBS)
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