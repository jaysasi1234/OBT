<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Cadet;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\AdminSystemNotification;

class ComplaintController extends Controller
{
    public function index()
    {
        // LOAD RELATIONSHIPS
        $complaints = Complaint::with(['cadet.batch'])->get();

        $selectedComplaint = request('complaint');

        // LOAD CADETS FOR ADD MODAL
        $cadets = Cadet::orderBy('full_name')->get();

        // COUNTS
        $open = Complaint::where('status', 'Open')->count();
        $resolved = Complaint::where('status', 'Resolved')->count();

        // CARDS
        $cadetsWithComplaint = Complaint::select('cadet_id')
            ->distinct()
            ->count('cadet_id');

        // COURSES
        $courses = Cadet::query()
            ->select('course')
            ->distinct()
            ->pluck('course')
            ->filter()
            ->values();

        // BATCHES
        $batches = Batch::query()
            ->select('batch_year')
            ->distinct()
            ->pluck('batch_year')
            ->filter()
            ->values();

        return view('admin.complaints.index', compact(
            'complaints',
            'cadets',
            'open',
            'resolved',
            'cadetsWithComplaint',
            'courses',
            'batches',
            'selectedComplaint'
        ));
    }

public function update(Request $request, Complaint $complaint)
{
    $request->validate([
        'status' => 'required|in:Open,Resolved',
        'action_taken' => 'nullable|string',
        'remarks' => 'nullable|string|max:255',
        'support_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    // Upload new support file
    if ($request->hasFile('support_file')) {

        if ($complaint->support_file &&
            Storage::disk('public')->exists($complaint->support_file)) {

            Storage::disk('public')->delete($complaint->support_file);
        }

        $complaint->support_file = $request
            ->file('support_file')
            ->store('complaints', 'public');
    }

    $complaint->status = $request->status;
    $complaint->action_taken = $request->action_taken;
    $complaint->remarks = $request->remarks;

    if ($request->status == 'Resolved') {
        $complaint->resolved_at = now();
    } else {
        $complaint->resolved_at = null;
    }

    $complaint->save();

    return redirect()
        ->route('admin.complaints.index')
        ->with('success', 'Concern updated successfully.');
}
    
    // =========================
// STORE COMPLAINT
// =========================
public function store(Request $request)
{
    $request->validate([
        'cadet_id' => 'required|exists:cadets,id',
        'subject' => 'required|string|max:255',
        'description' => 'required|string',
        'support_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $supportFile = null;

    if ($request->hasFile('support_file')) {

        $supportFile = $request->file('support_file')
            ->store('complaints', 'public');
    }

    $complaint = Complaint::create([
        'cadet_id' => $request->cadet_id,
        'subject' => $request->subject,
        'description' => $request->description,
        'support_file' => $supportFile,
        'status' => 'Open',
    ]);
    

// Notify Admins
$admins = User::where('role', 'admin')->get();

Notification::send($admins, new AdminSystemNotification(
    'New Concern Submitted',
    $complaint->cadet->full_name . ' submitted a concern: ' . $request->subject,
    '⚠️',
    route('admin.complaints.index', [
        'complaint' => $complaint->id
    ]),
    $complaint->cadet->user_id
));

// Notify Super Admin / Dean
$deans = User::where('role', 'dean')->get();

Notification::send($deans, new AdminSystemNotification(
    'New Concern Submitted',
    $complaint->cadet->full_name . ' submitted a concern: ' . $request->subject,
    '⚠️',
    route('superadmin.complaints.index', [
        'complaint' => $complaint->id
    ]),
    $complaint->cadet->user_id
));

    return redirect()
        ->route('admin.complaints.index')
        ->with('success', 'Concern added successfully!');
}
}
