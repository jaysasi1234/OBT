<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Cadet;

class ProfileController extends Controller
{
    // =========================================================
    // PROFILE PAGE
    // =========================================================

    public function index()
    {
        $user = Auth::user();

        return view('cadet.profile', compact('user'));
    }


    // =========================================================
    // SHOW EDIT PAGE
    // =========================================================

    public function edit()
    {
        $user = Auth::user();

        return view('cadet.profile_edit', compact('user'));
    }


    // =========================================================
    // UPDATE PERSONAL INFORMATION
    // =========================================================

    public function update(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'course'         => 'nullable|string|max:255',
            'date_of_birth'  => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'address'        => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'email'          => 'nullable|email|max:255',
        ]);

        $user = Auth::user();

        // -----------------------------------------------------
        // UPDATE USER TABLE
        // -----------------------------------------------------

        $user->update([
            'name'  => $request->name,
            'email' => $request->email ?? $user->email,
        ]);

        // -----------------------------------------------------
        // UPDATE CADET TABLE
        // -----------------------------------------------------

        $cadet = Cadet::where('user_id', $user->id)->first();

        if ($cadet) {
            $cadet->update([
                'full_name'        => $request->name,
                'course'           => $request->course,
                'date_of_birth'    => $request->date_of_birth,
                'place_of_birth'   => $request->place_of_birth,
                'address'          => $request->address,
                'contact_number'   => $request->contact_number,
            ]);
        }

        return redirect()
            ->route('cadet.profile')
            ->with('success', 'Profile updated successfully!');
    }


    // =========================================================
    // UPDATE GUARDIAN INFORMATION
    // =========================================================

    public function updateGuardian(Request $request)
    {
        $request->validate([
            'guardian_name'    => 'nullable|string|max:255',
            'relationship'     => 'nullable|string|max:100',
            'guardian_contact' => 'nullable|string|max:50',
            'guardian_address' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        $user->update([
            'guardian_name'    => $request->guardian_name,
            'relationship'     => $request->relationship,
            'guardian_contact' => $request->guardian_contact,
            'guardian_address' => $request->guardian_address,
        ]);

        return back()->with('success', 'Guardian information updated!');
    }


    // =========================================================
    // UPDATE PASSWORD
    // =========================================================

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }


    // =========================================================
    // UPLOAD PROFILE PHOTO
    // =========================================================

public function upload(Request $request)
{
    $request->validate([
        'photo' => [
            'required',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
    ]);

    $user = Auth::user();

    /*
    |--------------------------------------------------------------------------
    | DELETE OLD PROFILE PHOTO
    |--------------------------------------------------------------------------
    */

    if ($user->profile_picture) {

        $oldPath = $user->profile_picture;

        if (
            str_starts_with($oldPath, 'profile_pictures/')
            && Storage::disk('public')->exists($oldPath)
        ) {
            Storage::disk('public')->delete($oldPath);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | STORE NEW PHOTO
    |--------------------------------------------------------------------------
    */

    $path = $request
        ->file('photo')
        ->store('profile_pictures', 'public');

    /*
    |--------------------------------------------------------------------------
    | UPDATE USER
    |--------------------------------------------------------------------------
    */

    $user->profile_picture = $path;
    $user->save();

    /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('cadet.profile')
        ->with('success', 'Photo updated successfully!');
}
}