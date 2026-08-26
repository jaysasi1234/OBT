<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cadet;

class RemarkController extends Controller
{
    public function index(Request $request)
    {
        $query = Cadet::query();

        if ($request->month) {
            $query->where('remarks_month', $request->month);
        }

        if ($request->year) {
            $query->where('remarks_year', $request->year);
        }

        if ($request->search) {
            $query->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('course', 'like', '%' . $request->search . '%')
                  ->orWhere('trb_control_number', 'like', '%' . $request->search . '%');
        }

        $cadets = $query->latest()->paginate(10);

        return view(
            'superadmin.remarks.index',
            compact('cadets')
        );
    }

    public function show(Cadet $remark)
    {
        return view(
            'superadmin.remarks.show',
            compact('remark')
        );
    }
}