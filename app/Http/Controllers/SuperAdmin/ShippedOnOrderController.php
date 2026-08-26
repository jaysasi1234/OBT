<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Cadet;
use App\Models\ShippedOnOrder;
use Illuminate\Http\Request;

class ShippedOnOrderController extends Controller
{
    /**
     * Display Shipped On Order records.
     *
     * SUPER ADMIN = VIEW ONLY
     */
    public function index(Request $request)
    {
        $query = ShippedOnOrder::with('cadet');

        /*
        |--------------------------------------------------------------------------
        | COURSE FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('course')) {
            $query->whereHas('cadet', function ($q) use ($request) {
                $q->where('course', $request->course);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | BATCH FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('batch')) {
            $query->whereHas('cadet', function ($q) use ($request) {
                $q->where('batch_id', $request->batch);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $query->whereHas('cadet', function ($q) use ($request) {
                $q->where(
                    'full_name',
                    'like',
                    '%' . $request->search . '%'
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | ORDERS
        |--------------------------------------------------------------------------
        */

        $orders = $query
            ->join(
                'cadets',
                'shipped_on_orders.cadet_id',
                '=',
                'cadets.id'
            )
            ->orderBy('cadets.full_name', 'asc')
            ->select('shipped_on_orders.*')
            ->with('cadet')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | FILTER DATA
        |--------------------------------------------------------------------------
        */

        $courses = Cadet::select('course')
            ->distinct()
            ->orderBy('course')
            ->pluck('course');

        $batches = Batch::orderBy('batch_year')->get();

        /*
        |--------------------------------------------------------------------------
        | STATISTICS
        |--------------------------------------------------------------------------
        */

        $total = ShippedOnOrder::count();

        $pending = ShippedOnOrder::where(
            'status',
            'Pending'
        )->count();

        $endorsement = ShippedOnOrder::where(
            'status',
            'For Endorsement'
        )->count();

        $completed = ShippedOnOrder::where(
            'status',
            'Completed'
        )->count();

        return view(
            'superadmin.shipped_so.index',
            compact(
                'orders',
                'courses',
                'batches',
                'total',
                'pending',
                'endorsement',
                'completed'
            )
        );
    }

    /**
     * View one Shipped On Order record.
     *
     * SUPER ADMIN = VIEW ONLY
     */
    public function show(ShippedOnOrder $shippedOnOrder)
    {
        $shippedOnOrder->load('cadet');

        return response()->json($shippedOnOrder);
    }
}