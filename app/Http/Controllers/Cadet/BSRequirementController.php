<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Events\BSRequirementUploaded;
use App\Models\BSRequirement;
use App\Models\Cadet;
use App\Models\CadetBSRequirement;
use App\Models\User;
use App\Notifications\BSRequirementUploadedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class BSRequirementController extends Controller
{
    public function index()
    {
        $cadet = Cadet::where('user_id', Auth::id())
            ->with('deployment')
            ->firstOrFail();

        // BS requirements are only available after deployment is completed.
        $notCompleted = ! $cadet->deployment ||
            $cadet->deployment->status !== 'Completed';

        $requirements = collect();
        $submissions = collect();

        if (! $notCompleted) {
            $requirements = BSRequirement::where('is_active', true)
                ->orderBy('sort_order')
                ->get();

            $submissions = CadetBSRequirement::where('cadet_id', $cadet->id)
                ->get()
                ->keyBy('b_s_requirement_id');
        }

        return view('cadet.bs_requirements', compact(
            'cadet',
            'requirements',
            'submissions',
            'notCompleted'
        ));
    }

    public function upload(Request $request)
    {
        $validated = $request->validate([
            'requirement_id' => [
                'required',
                'integer',
                'exists:bs_requirements,id',
            ],
            'attachment' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png,doc,docx',
                'max:10240',
            ],
            'remarks' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $cadet = Cadet::where('user_id', Auth::id())
            ->with('deployment')
            ->firstOrFail();

        // Prevent uploading before onboard training is completed.
        if (
            ! $cadet->deployment ||
            $cadet->deployment->status !== 'Completed'
        ) {
            return back()->with(
                'error',
                'BS requirements are only available after completing onboard training.'
            );
        }

        /*
         * Store the file in:
         *
         * storage/app/public/bs-requirements/
         *
         * This works with:
         *
         * php artisan storage:link
         */
        $path = $request->file('attachment')
            ->store('bs-requirements', 'public');

        $submission = CadetBSRequirement::updateOrCreate(
            [
                'cadet_id' => $cadet->id,
                'b_s_requirement_id' => $validated['requirement_id'],
            ],
            [
                'attachment' => $path,
                'status' => 'Submitted',
                'remarks' => $validated['remarks'] ?? null,
                'submitted_at' => now(),
            ]
        );

        // Load relationships needed by the notification/event.
        $submission->load([
            'cadet',
            'requirement',
        ]);

        // Notify admins and superadmins.
        $admins = User::whereIn('role', [
            'admin',
            'superadmin',
        ])->get();

        if ($admins->isNotEmpty()) {
            Notification::send(
                $admins,
                new BSRequirementUploadedNotification($submission)
            );
        }

        // Broadcast realtime update.
        broadcast(
            new BSRequirementUploaded($submission)
        )->toOthers();

        return back()->with(
            'success',
            'BS Requirement uploaded successfully.'
        );
    }
}