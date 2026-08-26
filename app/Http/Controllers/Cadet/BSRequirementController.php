<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\BSRequirement;
use App\Models\Cadet;
use App\Models\CadetBSRequirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\BSRequirementUploaded;
use App\Models\User;
use App\Notifications\BSRequirementUploadedNotification;
use Illuminate\Support\Facades\Notification;

class BSRequirementController extends Controller
{
    public function index()
    {
        $cadet = Cadet::where('user_id', Auth::id())
            ->with('deployment')
            ->firstOrFail();

    // Only allow after deployment is completed
    $notCompleted = false;

    if (
        !$cadet->deployment ||
        $cadet->deployment->status !== 'Completed'
    ) {
        $notCompleted = true;
    }

    $requirements = collect();
    $submissions = collect();

    if (!$notCompleted) {
        $requirements = BSRequirement::where('is_active', 1)
            ->orderBy('sort_order')
            ->get();

        $submissions = CadetBSRequirement::where('cadet_id', $cadet->id)
            ->get()
            ->keyBy('b_s_requirement_id');
    }

    return view(
        'cadet.bs_requirements',
        compact(
            'cadet',
            'requirements',
            'submissions',
            'notCompleted'
        )
    );
}

    public function upload(Request $request)
    {
        $request->validate([
            'requirement_id' => 'required|exists:bs_requirements,id',
            'attachment' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $cadet = Cadet::where('user_id', Auth::id())->firstOrFail();

        $path = $request->file('attachment')
            ->store('bs-requirements', 'public');

        $submission = CadetBSRequirement::updateOrCreate(
            [
                'cadet_id' => $cadet->id,
                'b_s_requirement_id' => $request->requirement_id,
            ],
            [
                'attachment' => $path,
                'status' => 'Submitted',
                'remarks' => $request->remarks,
                'submitted_at' => now(),
            ],
        );

        // Load relationships used by the notification
        $submission->load([
            'cadet',
            'requirement',
        ]);

        // Notify all admins
        $admins = User::whereIn('role', [
            'admin',
            'superadmin',
        ])->get();

        Notification::send(
            $admins,
            new BSRequirementUploadedNotification($submission)
        );


        // Broadcast realtime update
        broadcast(new BSRequirementUploaded($submission))->toOthers();

        return back()->with(
            'success',
            'BS Requirement uploaded successfully.'
        );
    }
}