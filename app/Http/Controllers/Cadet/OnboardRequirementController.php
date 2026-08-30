<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\OnboardRequirement;
use App\Models\CadetOnboardRequirement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CadetRequirementSubmitted;

class OnboardRequirementController extends Controller
{
    // =========================================================
    // INDEX
    // =========================================================

    public function index()
    {
        $cadet = Cadet::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        // =====================================================
        // CHECK IF CADET IS DEPLOYED
        // =====================================================

        $deployment = $cadet->deployment;

        if (
            !$deployment ||
            $deployment->status !== 'Ongoing'
        ) {
            return view(
                'cadet.onboard_requirements',
                [
                    'requirements' => collect(),
                    'submissions' => collect(),
                    'cadet' => $cadet,
                    'notDeployed' => true,
                ]
            );
        }

        // =====================================================
        // ACTIVE REQUIREMENTS
        // =====================================================

        $requirements = OnboardRequirement::where(
            'is_active',
            true
        )
        ->orderBy('sort_order')
        ->get();

        // =====================================================
        // CADET SUBMISSIONS
        // =====================================================

        $submissions = CadetOnboardRequirement::where(
            'cadet_id',
            $cadet->id
        )
        ->get()
        ->keyBy('onboard_requirement_id');

        return view(
            'cadet.onboard_requirements',
            compact(
                'requirements',
                'submissions',
                'cadet'
            )
        );
    }


    // =========================================================
    // UPLOAD / SUBMIT REQUIREMENT
    // =========================================================

    public function upload(Request $request)
    {
        // =====================================================
        // VALIDATION
        // =====================================================

        $validated = $request->validate([
            'requirement_id' => [
                'required',
                'exists:onboard_requirements,id',
            ],

            'attachment' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);


        // =====================================================
        // GET CADET
        // =====================================================

        $cadet = Auth::user()->cadet;

        if (!$cadet) {
            return back()->with(
                'error',
                'Cadet record could not be found.'
            );
        }


        // =====================================================
        // GET REQUIREMENT
        // =====================================================

        $requirement = OnboardRequirement::findOrFail(
            $validated['requirement_id']
        );


        // =====================================================
        // STORE ATTACHMENT
        // =====================================================

        $file = $request
            ->file('attachment')
            ->store(
                'onboard_requirements',
                'public'
            );


        // =====================================================
        // SAVE SUBMISSION
        // =====================================================

        $submission =
            CadetOnboardRequirement::updateOrCreate(
                [
                    'cadet_id' =>
                        $cadet->id,

                    'onboard_requirement_id' =>
                        $requirement->id,
                ],
                [
                    'attachment' =>
                        $file,

                    'remarks' =>
                        $validated['remarks'] ?? null,

                    /*
                     * A newly uploaded requirement is waiting
                     * for admin review.
                     */
                    'status' =>
                        'Pending',

                    'submitted_at' =>
                        now(),
                ]
            );


        // =====================================================
        // FIND ADMIN RECIPIENTS
        // =====================================================

        /*
         * Do NOT use:
         *
         * User::where('role', 'admin')
         *
         * because role capitalization may differ.
         *
         * We also include super_admin.
         */

        $admins = User::whereIn(
            'role',
            [
                'admin',
                'Admin',
                'ADMIN',
                'super_admin',
                'Super Admin',
                'SUPER_ADMIN',
            ]
        )->get();


        // =====================================================
        // SEND REALTIME + DATABASE NOTIFICATION
        // =====================================================

        foreach ($admins as $admin) {

            $admin->notify(
                new CadetRequirementSubmitted(
                    $cadet,
                    $requirement
                )
            );
        }


        // =====================================================
        // LOG NOTIFICATION RECIPIENTS
        // =====================================================

        \Log::info(
            'Cadet onboard requirement submitted.',
            [
                'cadet_id' =>
                    $cadet->id,

                'cadet_user_id' =>
                    $cadet->user_id,

                'requirement_id' =>
                    $requirement->id,

                'submission_id' =>
                    $submission->id,

                'admin_user_ids' =>
                    $admins
                        ->pluck('id')
                        ->values()
                        ->toArray(),
            ]
        );


        // =====================================================
        // RESPONSE
        // =====================================================

        return back()->with(
            'success',
            'Requirement uploaded successfully.'
        );
    }
}