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

public function update(Request $request)
{
    $request->validate([
        'name'           => 'required|string|max:255',
        'date_of_birth'  => 'nullable|date',
        'place_of_birth' => 'nullable|string|max:255',
        'address'        => 'nullable|string|max:255',
        'contact_number' => 'nullable|string|max:50',

        // Guardian fields
        'guardian_name'    => 'nullable|string|max:255',
        'relationship'     => 'nullable|string|max:100',
        'guardian_contact' => 'nullable|string|max:50',
        'guardian_address' => 'nullable|string|max:255',
    ]);

    $user = Auth::user();

    /*
    |--------------------------------------------------------------------------
    | UPDATE USER
    |--------------------------------------------------------------------------
    */

    $user->update([
        'name'            => $request->name,
        'guardian_name'   => $request->guardian_name,
        'relationship'    => $request->relationship,
        'guardian_contact'=> $request->guardian_contact,
        'guardian_address'=> $request->guardian_address,
    ]);

    /*
    |--------------------------------------------------------------------------
    | UPDATE CADET
    |--------------------------------------------------------------------------
    */

    $cadet = Cadet::where('user_id', $user->id)->first();

    if ($cadet) {

        $cadet->update([
            'full_name'      => $request->name,
            'date_of_birth'  => $request->date_of_birth,
            'place_of_birth' => $request->place_of_birth,
            'address'        => $request->address,
            'contact_number' => $request->contact_number,

            /*
             * IMPORTANT:
             * Do NOT update course here.
             *
             * The cadet profile Blade currently does not
             * submit a course field.
             *
             * Therefore we preserve the existing database value.
             */
        ]);
    }

    return redirect()
        ->route('cadet.profile')
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

    // 👉 UPLOAD PHOTO
public function upload(Request $request)
{
    $request->validate([
        'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $user = Auth::user();

    $path = $request->file('photo')->store('profile_pictures', 'public');

    $user->profile_picture = $path;
    $user->save();

    $cadet = Cadet::where('user_id', $user->id)->first();

    if ($cadet) {
        $cadet->photo = $path;
        $cadet->save();
    }

    return back()->with('success','Photo updated successfully.');
}
}