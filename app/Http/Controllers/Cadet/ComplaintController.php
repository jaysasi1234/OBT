<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Cadet;
use App\Models\ComplaintType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminSystemNotification;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::where('user_id', Auth::id())
            ->latest()
            ->get();

        $complaintTypes = ComplaintType::all();

        return view('cadet.complaints', compact(
            'complaints',
            'complaintTypes'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|exists:complaint_types,complaint_type',
            'description' => 'required|string',
        ]);

        $user = Auth::user();

        // =========================
        // CHECK LOGIN
        // =========================
        if (!$user) {
            return back()->with('error', 'You must be logged in.');
        }

        // =========================
        // CHECK ROLE
        // =========================
        if ($user->role !== 'cadet') {
            return back()->with('error', 'Only cadets are allowed to submit concerns.');
        }

        // =========================
        // GET OR CREATE CADET PROFILE
        // =========================
        $cadet = Cadet::where('user_id', $user->id)->first();

        if (!$cadet) {
            $cadet = Cadet::create([
                'user_id' => $user->id,
                'trb_control_number' => 'TRB-' . rand(10000, 99999),
                'full_name' => $user->name,
                'course' => $user->course,
                'batch_id' => null,
                'date_of_birth' => '2000-01-01',
                'place_of_birth' => 'Unknown',
                'rank' => 'Cadet',
                'address' => 'Not provided',
                'contact_number' => $user->contact ?? '0000000000',
                'email' => $user->email,
            ]);
        }

        // =========================
        // CREATE COMPLAINT
        // =========================
        $complaint = Complaint::create([
            'cadet_id' => $cadet->id,
            'user_id' => $user->id,
            'subject' => $request->subject,
            'description' => $request->description,
            'status' => 'Open',
            'action_taken' => null,
            'resolved_at' => null,
        ]);

        $admins = User::where('role','admin')->get();

Notification::send($admins,new AdminSystemNotification(

    'New Concern Submitted',

    $user->name.' submitted a concern: '.$request->subject,

    '⚠️',

    route('admin.complaints.index',[
        'complaint'=>$complaint->id
    ]),

    $user->id

));
        // =========================
// CREATE NOTIFICATION FOR DEAN
// =========================
$deans = User::where('role', 'dean')->get();

Notification::send($deans, new AdminSystemNotification(

    'New Concern Submitted',

    $user->name . ' submitted a concern: ' . $request->subject,

    '⚠️',

    route('superadmin.complaints.index', [
        'complaint' => $complaint->id,
    ]),

    $user->id

));

        return back()->with('success', 'Concern submitted successfully.');
    }
}