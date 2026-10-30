<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\BSRequirement;
use App\Models\Batch;
use Illuminate\Http\Request;

class CadetBSRequirementController extends Controller
{
    /**
     * Display BS requirements for completed cadets.
     * SUPER ADMIN = VIEW ONLY
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | BASE CADET QUERY
        |--------------------------------------------------------------------------
        */

        $query = Cadet::query()
            ->with([
                'batch',
                'deployment',
                'bsRequirements.requirement'
            ])
            ->whereHas('deployment', function ($q) {
                $q->where('status', 'Completed');
            });

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
        | TOTAL BS REQUIREMENTS
        |--------------------------------------------------------------------------
        */

        $totalRequirements = BSRequirement::count();

        /*
        |--------------------------------------------------------------------------
        | STATISTICS - ALL MATCHING CADETS
        |--------------------------------------------------------------------------
        |
        | This calculates statistics across all filtered cadets,
        | not only the 25 cadets displayed on the current page.
        |
        */

        $stats = (clone $query)
            ->withCount('bsRequirements')
            ->get(['id']);

        $totalCadets = $stats->count();

        $submittedRequirements = $stats->sum(
            'bs_requirements_count'
        );

        $pendingCadets = $stats->filter(function ($cadet) use ($totalRequirements) {
            return $cadet->bs_requirements_count < $totalRequirements;
        })->count();

        $completedCadets = $stats->filter(function ($cadet) use ($totalRequirements) {
            return $cadet->bs_requirements_count >= $totalRequirements;
        })->count();

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
        | FILTER OPTIONS
        |--------------------------------------------------------------------------
        */

        $batches = Batch::orderBy('batch_year', 'desc')->get();

        $courses = Cadet::select('course')
            ->whereNotNull('course')
            ->where('course', '!=', '')
            ->distinct()
            ->orderBy('course')
            ->pluck('course');

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'superadmin.cadet_bs_requirements.index',
            compact(
                'cadets',
                'totalRequirements',
                'courses',
                'batches',
                'totalCadets',
                'submittedRequirements',
                'pendingCadets',
                'completedCadets'
            )
        );
    }

    /**
     * View a specific cadet's BS requirements.
     * SUPER ADMIN = VIEW ONLY
     */
    public function show(Cadet $cadet)
    {
        $cadet->load([
            'batch',
            'deployment',
            'bsRequirements.requirement'
        ]);

        return view(
            'superadmin.cadet_bs_requirements.show',
            compact('cadet')
        );
    }
}
