<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RemarkController extends Controller
{
    // =========================
    // INDEX (DASHBOARD VIEW)
    // =========================
    public function index(Request $request)
    {
        $query = Cadet::query();

        // SEARCH (optional but useful)
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // FILTER BY YEAR (batch year)
        if ($request->year) {
            $query->whereHas('batch', function ($q) use ($request) {
                $q->where('year', $request->year);
            });
        }

        $cadets = $query->with('batch')->get();

        // STATS
        $total = Cadet::count();

        $withRemarks = Cadet::whereNotNull('remarks')
            ->where('remarks', '!=', '')
            ->count();

        $noRemarks = Cadet::whereNull('remarks')
            ->orWhere('remarks', '')
            ->count();

        return view('admin.remarks.index', compact(
            'cadets',
            'total',
            'withRemarks',
            'noRemarks'
        ));
    }

    // =========================
    // UPDATE REMARK
    // =========================
    public function update(Request $request, int $id)
    {
        $request->validate([
            'remarks' => 'nullable|string',
            'month' => 'nullable|string',
            'year' => 'nullable|string',
        ]);

        $cadet = Cadet::findOrFail($id);

        $cadet->remarks = $request->remarks;
        $cadet->remarks_month = $request->month;
        $cadet->remarks_year = $request->year;

        // optional tracking
        $cadet->remarks_updated_by = Auth::user()?->name ?? 'Admin';

        $cadet->save();

        return back()->with('success', 'Remark updated successfully!');
    }

    // =========================
    // DELETE REMARK
    // =========================
    public function destroy(int $id)
    {
        $cadet = Cadet::findOrFail($id);

        $cadet->remarks = null;
        $cadet->remarks_month = null;
        $cadet->remarks_year = null;
        $cadet->remarks_updated_by = null;

        $cadet->save();

        return back()->with('success', 'Remark deleted successfully!');
    }
}