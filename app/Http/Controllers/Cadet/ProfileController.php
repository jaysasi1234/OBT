<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cadet;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // 👉 PROFILE PAGE
    public function index()
    {
        $user = Auth::user();
        return view('cadet.profile', compact('user'));
    }

    // 👉 SHOW EDIT PAGE
    public function edit()
    {
        $user = Auth::user();
        return view('cadet.profile_edit', compact('user'));
    }

    // 👉 UPDATE PERSONAL INFO
public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'course' => 'nullable|string|max:255',
        'dob' => 'nullable|date',
        'birth_place' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'contact_no' => 'nullable|string|max:50',
    ]);

    $user = Auth::user();

    // Update User table
    $user->update([
        'name' => $request->name,
    ]);

    // Update Cadet table
    $cadet = Cadet::where('user_id', $user->id)->first();

    if ($cadet) {
        $cadet->update([
            'full_name'        => $request->name,
            'course'           => $request->course,
            'date_of_birth'    => $request->dob,
            'place_of_birth'   => $request->birth_place,
            'address'          => $request->address,
            'contact_number'   => $request->contact_no,
        ]);
    }

    return redirect()->route('cadet.profile')
        ->with('success', 'Profile updated successfully!');
}

    // 👉 UPDATE GUARDIAN INFO
    public function updateGuardian(Request $request)
    {
        $request->validate([
            'guardian_name' => 'nullable|string|max:255',
            'relationship' => 'nullable|string|max:100',
            'guardian_contact' => 'nullable|string|max:50',
            'guardian_address' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        $user->update([
            'guardian_name' => $request->guardian_name,
            'relationship' => $request->relationship,
            'guardian_contact' => $request->guardian_contact,
            'guardian_address' => $request->guardian_address,
        ]);

        return back()->with('success', 'Guardian information updated!');
    }

    // 👉 UPDATE PASSWORD
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect'
            ]);
        }

        // update password
        $user->update([
            'password' => bcrypt($request->new_password)
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

public function upload(Request $request)
{
    $request->validate([
        'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $user = Auth::user();

    // Store new photo first
    $path = $request->file('photo')->store('profile_pictures', 'public');

    if (!$path) {
        return back()->with('error', 'Photo upload failed.');
    }

    // Delete old photo after successful upload
    if (
        $user->profile_picture &&
        Storage::disk('public')->exists($user->profile_picture)
    ) {
        Storage::disk('public')->delete($user->profile_picture);
    }

    // Update user profile picture
    $user->profile_picture = $path;
    $user->save();

    // Update cadet photo
    $cadet = Cadet::where('user_id', $user->id)->first();

    if ($cadet) {
        $cadet->update([
            'photo' => $path,
        ]);
    }

    return redirect()
        ->route('cadet.profile')
        ->with('success', 'Photo updated successfully.');
}
}