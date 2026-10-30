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
        | CADETS QUERY
        |--------------------------------------------------------------------------
        */

        $query = Cadet::with([
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

            $query->whereRaw(
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

            $query->whereHas('batch', function ($batchQuery) use ($batch) {
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

                // Includes cadets without a deployment and deployments
                // whose status is not Ongoing or Completed.
                $query->whereDoesntHave('deployment')
                    ->orWhereHas('deployment', function ($deploymentQuery) {
                        $deploymentQuery->whereRaw(
                            "LOWER(TRIM(COALESCE(status, ''))) NOT IN (?, ?)",
                            ['ongoing', 'completed']
                        );
                    });

            } elseif (in_array($deployment, ['ongoing', 'completed'], true)) {

                $query->whereHas('deployment', function ($deploymentQuery) use ($deployment) {
                    $deploymentQuery->whereRaw(
                        'LOWER(TRIM(status)) = ?',
                        [$deployment]
                    );
                });
            }
        }

        /*
        |--------------------------------------------------------------------------
        | VERIFICATION FILTER
        |--------------------------------------------------------------------------
        */

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
        | SEARCH FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($searchQuery) use ($search) {
                $searchQuery
                    ->where('full_name', 'like', "%{$search}%")
                    ->orWhere('trb_control_number', 'like', "%{$search}%")
                    ->orWhere('course', 'like', "%{$search}%")
                    ->orWhere('rank', 'like', "%{$search}%");
            });
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
        | GLOBAL STATISTICS
        | These counts are not affected by table filters.
        |--------------------------------------------------------------------------
        */

        $totalCadets = Cadet::count();

        $verifiedCadets = Cadet::where(
            'verification_status',
            'Verified'
        )->count();

        $pendingCadets = Cadet::where(
            'verification_status',
            'Pending'
        )->count();

        $deficiencyCadets = Cadet::where(
            'verification_status',
            'Deficiency'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | VIEW
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
