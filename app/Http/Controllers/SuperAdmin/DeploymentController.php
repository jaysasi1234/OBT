<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Deployment;
use App\Models\Cadet;
use App\Models\Batch;
use Illuminate\Http\Request;

class DeploymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Deployment::with(['cadet.batch']);

        // ==========================================
        // SEARCH BY CADET NAME
        // ==========================================

        if ($request->filled('name')) {

            $query->whereHas('cadet', function ($q) use ($request) {

                $q->where(
                    'full_name',
                    'like',
                    '%' . $request->name . '%'
                );

            });

        }


        // ==========================================
        // FILTER BY COURSE
        // ==========================================

        if ($request->filled('course')) {

            $query->whereHas('cadet', function ($q) use ($request) {

                $q->where(
                    'course',
                    $request->course
                );

            });

        }


        // ==========================================
        // FILTER BY BATCH
        // ==========================================

        if ($request->filled('batch')) {

            $query->whereHas('cadet', function ($q) use ($request) {

                $q->where(
                    'batch_id',
                    $request->batch
                );

            });

        }


        // ==========================================
        // FILTER BY DEPLOYMENT STATUS
        // ==========================================

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }


        // ==========================================
        // ORDER CADETS A-Z
        // ==========================================

        $deployments = $query
            ->join(
                'cadets',
                'deployments.cadet_id',
                '=',
                'cadets.id'
            )
            ->select('deployments.*')
            ->orderBy('cadets.full_name', 'asc')
            ->paginate(10)
            ->withQueryString();


        // ==========================================
        // DROPDOWN DATA
        // ==========================================

        $courses = Cadet::select('course')
            ->distinct()
            ->orderBy('course')
            ->pluck('course');


        $batches = Batch::orderByDesc('batch_year')
            ->get();


        // ==========================================
        // DASHBOARD STATISTICS
        // ==========================================

        $totalCadets = Cadet::count();


        $ongoing = Deployment::where(
            'status',
            'Ongoing'
        )->count();


        $completed = Deployment::where(
            'status',
            'Completed'
        )->count();


        // Total deployed
        $totalDeployed =
            $ongoing +
            $completed;


        // Cadets without deployment
        $notDeployed =
            $totalCadets -
            $totalDeployed;


        return view(
            'superadmin.deployments.index',
            compact(
                'deployments',
                'courses',
                'batches',
                'totalCadets',
                'totalDeployed',
                'ongoing',
                'completed',
                'notDeployed'
            )
        );
    }


    public function show(int $id)
    {
        $deployment = Deployment::with([
            'cadet.batch'
        ])->findOrFail($id);


        return view(
            'superadmin.deployments.show',
            compact('deployment')
        );
    }
}