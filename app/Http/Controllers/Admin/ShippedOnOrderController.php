<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\ShippedOnOrder;
use Illuminate\Http\Request;

class ShippedOnOrderController extends Controller
{
public function index(Request $request)
{
    $query = ShippedOnOrder::with('cadet');

    if ($request->filled('course')) {
        $query->whereHas('cadet', function ($q) use ($request) {
            $q->where('course', $request->course);
        });
    }

    if ($request->filled('batch')) {
        $query->whereHas('cadet', function ($q) use ($request) {
            $q->where('batch_id', $request->batch);
        });
    }

    if ($request->filled('search')) {
        $query->whereHas('cadet', function ($q) use ($request) {
            $q->where('full_name', 'like', '%' . $request->search . '%');
        });
    }

    $orders = $query
    ->join('cadets', 'shipped_on_orders.cadet_id', '=', 'cadets.id')
    ->orderBy('cadets.full_name', 'asc')
    ->select('shipped_on_orders.*')
    ->with('cadet')
    ->get();

    $courses = Cadet::select('course')
        ->distinct()
        ->orderBy('course')
        ->pluck('course');

    $batches = \App\Models\Batch::orderBy('batch_year')->get();

    // existing counts...
    $total = ShippedOnOrder::count();
    $pending = ShippedOnOrder::where('status','Pending')->count();
    $endorsement = ShippedOnOrder::where('status','For Endorsement')->count();
    $completed = ShippedOnOrder::where('status','Completed')->count();

    $existingCadetIds = ShippedOnOrder::pluck('cadet_id');

    $cadets = Cadet::whereHas('deployment', function ($q) {
            $q->where('status', 'Completed');
        })
        ->whereNotIn('id', $existingCadetIds)
        ->orderBy('full_name', 'asc')
        ->get();

    return view('admin.shipped_so.index', compact(
        'orders',
        'cadets',
        'courses',
        'batches',
        'total',
        'pending',
        'endorsement',
        'completed'
    ));
}

    public function create()
    {
        return redirect()->route('admin.shipped-so.index');
    }


public function store(Request $request)
{
    $validated = $request->validate([
        'cadet_id' => 'required|exists:cadets,id|unique:shipped_on_orders,cadet_id',
        'deliberation_date' => 'nullable|date',
        'obt_endorsement_date' => 'nullable|date',
        'so_number' => 'nullable|string|max:100',
        'so_date_issued' => 'nullable|date',
        'status' => 'required|in:Pending,For Deliberation,For Endorsement,Shipped,Completed',
        'remarks' => 'nullable|string',
    ]);

    ShippedOnOrder::create($validated);

    return redirect()
        ->route('admin.shipped-so.index')
        ->with('success', 'Shipped On Order record created successfully.');
}

    public function show(string $id)
    {
        $order = ShippedOnOrder::with('cadet')->findOrFail($id);

        return response()->json($order);
    }


    public function edit(string $id)
    {
        $order = ShippedOnOrder::with('cadet')->findOrFail($id);

        return response()->json($order);
    }


public function update(Request $request, string $id)
{
    $order = ShippedOnOrder::findOrFail($id);

    $validated = $request->validate([
        'deliberation_date' => 'nullable|date',
        'obt_endorsement_date' => 'nullable|date',
        'so_number' => 'nullable|string|max:100',
        'so_date_issued' => 'nullable|date',
        'status' => 'required|in:Pending,For Deliberation,For Endorsement,Shipped,Completed',
        'remarks' => 'nullable|string',
    ]);

    $order->update($validated);

    return redirect()
        ->route('admin.shipped-so.index')
        ->with('success', 'Shipped On Order updated successfully.');
}


    public function destroy(string $id)
    {
        $order = ShippedOnOrder::findOrFail($id);

        $order->delete();

        return redirect()
            ->route('admin.shipped-so.index')
            ->with('success', 'Record deleted successfully.');
    }
}