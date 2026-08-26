<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->paginate(10);

        return view('superadmin.notifications', compact('notifications'));
    }

    public function markAsRead(string $id)
    {
        $notification = Auth::user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead();

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllRead()
    {
        Auth::user()
            ->unreadNotifications
            ->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    public function delete(string $id)
    {
        $notification = Auth::user()
            ->notifications()
            ->findOrFail($id);

        $notification->delete();

        return back()->with('success', 'Notification deleted.');
    }

    public function show(string $id)
    {
        $notification = Auth::user()
            ->notifications()
            ->findOrFail($id);

        // Mark notification as read
        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        /*
        |--------------------------------------------------------------------------
        | Complaint Notification
        |--------------------------------------------------------------------------
        | Redirect to the complaint list and automatically open the modal.
        */
        if (
            isset($notification->data['title']) &&
            $notification->data['title'] === 'New Complaint Submitted'
        ) {
            $complaintId = null;

            // Extract complaint id from the stored URL
            if (!empty($notification->data['url'])) {

                parse_str(
                    parse_url($notification->data['url'], PHP_URL_QUERY),
                    $query
                );

                $complaintId = $query['complaint'] ?? null;
            }

            return redirect()->route(
                'superadmin.complaints.index',
                ['complaint' => $complaintId]
            );
        }

        // Other notifications
        if (!empty($notification->data['url'])) {
            return redirect($notification->data['url']);
        }

        return redirect()->route('superadmin.notifications');
    }
}