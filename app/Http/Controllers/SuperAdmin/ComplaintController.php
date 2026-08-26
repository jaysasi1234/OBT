<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $selectedComplaint = $request->complaint;
        $query = Complaint::query();

        if ($request->search) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $complaints = $query
            ->latest()
            ->paginate(10);

        $totalComplaints = Complaint::count();
        $openComplaints = Complaint::where('status', 'open')->count();
        $resolvedComplaints = Complaint::where('status', 'resolved')->count();

        return view(
            'superadmin.complaints.index',
            compact(
                'complaints',
                'totalComplaints',
                'openComplaints',
                'resolvedComplaints',
                'selectedComplaint'
            )
        );
    }
}    