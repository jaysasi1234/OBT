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
     *
     * SUPER ADMIN = VIEW ONLY
     */
    public function index(Request $request)
    {
        $query = Cadet::with([
            'batch',
            'deployment',
            'bsRequirements.requirement'
        ])
        ->whereHas('deployment', function ($q) {
            $q->where('status', 'Completed');
        });

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where(
                    'full_name',
                    'like',
                    '%' . $request->search . '%'
                )

                ->orWhere(
                    'trb_control_number',
                    'like',
                    '%' . $request->search . '%'
                );

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
        | GET CADETS
        |--------------------------------------------------------------------------
        */

        $cadets = $query
            ->get()
            ->sortBy(function ($cadet) {
                return strtolower($cadet->full_name);
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | FILTER DATA
        |--------------------------------------------------------------------------
        */

        $batches = Batch::orderBy(
            'batch_year'
        )->get();

        $courses = Cadet::select('course')
            ->distinct()
            ->orderBy('course')
            ->pluck('course');

        /*
        |--------------------------------------------------------------------------
        | TOTAL BS REQUIREMENTS
        |--------------------------------------------------------------------------
        */

        $totalRequirements = BSRequirement::count();

        return view(
            'superadmin.cadet_bs_requirements.index',
            compact(
                'cadets',
                'totalRequirements',
                'courses',
                'batches'
            )
        );
    }


    /**
     * View a specific cadet's BS requirements.
     *
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