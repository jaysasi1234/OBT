<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\OnboardRequirement;
use App\Models\CadetOnboardRequirement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\CadetRequirementSubmitted;

class OnboardRequirementController extends Controller
{
public function index()
{
    $cadet = Cadet::where('user_id', Auth::id())
        ->firstOrFail();


    // CHECK IF CADET IS DEPLOYED
    $deployment = $cadet->deployment;


    if(
        !$deployment ||
        $deployment->status !== 'Ongoing'
    ){

        return view(
            'cadet.onboard_requirements',
            [
                'requirements' => collect(),
                'submissions' => collect(),
                'cadet' => $cadet,
                'notDeployed' => true
            ]
        );

    }


    $requirements = OnboardRequirement::where('is_active',1)
        ->orderBy('sort_order')
        ->get();


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

public function upload(Request $request)
{
    $request->validate([
        'requirement_id' => 'required|exists:onboard_requirements,id',
        'attachment' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'remarks' => 'nullable|string'
    ]);

    $cadet = Auth::user()->cadet;

    $file = $request->file('attachment')
        ->store('onboard_requirements', 'public');


    CadetOnboardRequirement::updateOrCreate(
        [
            'cadet_id' => $cadet->id,
            'onboard_requirement_id' => $request->requirement_id
        ],
        [
            'attachment' => $file,
            'remarks' => $request->remarks,
            'status' => 'Pending',
            'submitted_at' => now()
        ]
    );


    // GET REQUIREMENT
    $requirement = OnboardRequirement::find(
        $request->requirement_id
    );


    // SEND NOTIFICATION TO ALL ADMINS
    $admins = User::where('role','admin')->get();

    foreach($admins as $admin)
    {
        $admin->notify(
            new CadetRequirementSubmitted(
                $cadet,
                $requirement
            )
        );
    }


    return back()->with(
        'success',
        'Requirement uploaded successfully.'
    );
}
}