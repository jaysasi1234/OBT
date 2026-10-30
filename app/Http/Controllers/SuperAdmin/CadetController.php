<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Batch;

class CadetController extends Controller
{
    public function index()
    {
        // ================================================================
        // CADETS — ORDERED A-Z WITH PAGINATION
        // ================================================================

        $cadets = Cadet::with([
            'batch',
            'deployment'
        ])
        ->orderBy('full_name', 'asc')
        ->paginate(25)
        ->withQueryString();


        // ================================================================
        // COURSES
        // ================================================================

        $courses = Cadet::select('course')
            ->distinct()
            ->orderBy('course')
            ->get();


        // ================================================================
        // BATCHES
        // ================================================================

        $batches = Batch::orderBy('id', 'desc')->get();


        // ================================================================
        // STATISTICS — COUNT ALL CADETS, NOT JUST THE CURRENT PAGE
        // ================================================================

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


        // ================================================================
        // VIEW
        // ================================================================

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
