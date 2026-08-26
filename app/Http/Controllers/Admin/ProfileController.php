<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // SHOW PROFILE PAGE
    public function index()
    {
        return view('admin.profile');
    }

    // UPDATE PROFILE
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // UPLOAD PROFILE PHOTO
        if ($request->hasFile('profile_picture')) {

        if ($user->profile_picture &&
            Storage::disk('public')->exists($user->profile_picture)) {

            Storage::disk('public')->delete($user->profile_picture);
        }

        $path = $request->file('profile_picture')
                    ->store('profile_pictures', 'public');

        $user->profile_picture = $path;
        }

        // UPDATE USER INFO
        $user->name = $request->name;
        $user->email = $request->email;
        $user->contact = $request->contact;

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    // CHANGE PASSWORD
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // CHECK CURRENT PASSWORD
        if (!Hash::check($request->current_password, $user->password)) {

            return back()->with('error', 'Current password is incorrect.');
        }

        // UPDATE PASSWORD
        $user->password = Hash::make($request->new_password);

        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }
}