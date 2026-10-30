<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Batch;
use Illuminate\Http\Request;

class CadetController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        | Applies Course, Batch, Deployment, and Search filters.
        | Verification is intentionally excluded so all four card counts
        | remain visible even when one verification card is selected.
        |--------------------------------------------------------------------------
        */

        $baseQuery = Cadet::query()->with([
            'batch',
            'deployment'
        ]);

        /*
        |--------------------------------------------------------------------------
        | COURSE FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('course')) {

            $course = strtolower(trim($request->course));

            $baseQuery->whereRaw(
                'LOWER(TRIM(course)) = ?',
                [$course]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | BATCH FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('batch')) {

            $batch = strtolower(trim($request->batch));

            $baseQuery->whereHas('batch', function ($batchQuery) use ($batch) {

                $batchQuery->whereRaw(
                    'LOWER(TRIM(batch_year)) = ?',
                    [$batch]
                );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | DEPLOYMENT FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('deployment')) {

            $deployment = strtolower(trim($request->deployment));

            if ($deployment === 'not_deployed') {

                $baseQuery->where(function ($deploymentQuery) {

                    $deploymentQuery
                        ->whereDoesntHave('deployment')
                        ->orWhereHas('deployment', function ($query) {

                            $query->whereRaw(
                                "LOWER(TRIM(COALESCE(status, ''))) NOT IN (?, ?)",
                                ['ongoing', 'completed']
                            );

                        });

                });

            } elseif (in_array($deployment, ['ongoing', 'completed'], true)) {

                $baseQuery->whereHas('deployment', function ($query) use ($deployment) {

                    $query->whereRaw(
                        'LOWER(TRIM(status)) = ?',
                        [$deployment]
                    );

                });
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $baseQuery->where(function ($searchQuery) use ($search) {

                $searchQuery
                    ->where('full_name', 'like', "%{$search}%")
                    ->orWhere('trb_control_number', 'like', "%{$search}%")
                    ->orWhere('course', 'like', "%{$search}%")
                    ->orWhere('rank', 'like', "%{$search}%");

            });
        }

        /*
        |--------------------------------------------------------------------------
        | DYNAMIC STATISTICS
        | Counts change according to Course, Batch, Deployment, and Search.
        |--------------------------------------------------------------------------
        */

        // TOTAL matching cadets
        $totalCadets = (clone $baseQuery)->count();

        // VERIFIED matching cadets
        $verifiedCadets = (clone $baseQuery)
            ->whereRaw(
                "LOWER(TRIM(COALESCE(verification_status, 'pending'))) = ?",
                ['verified']
            )
            ->count();

        // PENDING matching cadets
        $pendingCadets = (clone $baseQuery)
            ->whereRaw(
                "LOWER(TRIM(COALESCE(verification_status, 'pending'))) = ?",
                ['pending']
            )
            ->count();

        // DEFICIENCY matching cadets
        $deficiencyCadets = (clone $baseQuery)
            ->whereRaw(
                "LOWER(TRIM(COALESCE(verification_status, 'pending'))) = ?",
                ['deficiency']
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | TABLE QUERY
        | Clone the base query and apply the selected verification filter.
        |--------------------------------------------------------------------------
        */

        $query = clone $baseQuery;

        if ($request->filled('verification')) {

            $verification = strtolower(trim($request->verification));

            if (in_array($verification, ['verified', 'pending', 'deficiency'], true)) {

                $query->whereRaw(
                    "LOWER(TRIM(COALESCE(verification_status, 'pending'))) = ?",
                    [$verification]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ORDERING AND PAGINATION
        |--------------------------------------------------------------------------
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

        $batches = Batch::orderBy('id', 'desc')->get();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'superadmin.cadets.index',
            compact(
                'cadets',
                'courses',
                'batches',
                'totalCadets',
                'verifiedCadets',
                'pendingCadets',
                'deficiencyCadets'
            )
        );
    }
}
