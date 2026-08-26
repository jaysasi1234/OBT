<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->paginate(20);

        return view('admin.notifications.index', compact('notifications'));
    }


    public function readAll()
    {
        Auth::user()
            ->unreadNotifications
            ->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }


    public function deleteSelected(Request $request)
    {

        $request->validate([
            'notifications' => 'required|array'
        ]);


        Auth::user()
            ->notifications()
            ->whereIn('id', $request->notifications)
            ->delete();


        return back()->with('success', 'Selected notifications deleted successfully.');
    }


    public function destroy(string $id)
    {
        $notification = Auth::user()
            ->notifications()
            ->find($id);


        if($notification){
            $notification->delete();
        }


        return back()->with('success','Notification deleted successfully.');
    }
}