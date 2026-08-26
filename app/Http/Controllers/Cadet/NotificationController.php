<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display all notifications for the authenticated cadet.
     */
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->get();

        return view('cadet.notifications', compact('notifications'));
    }

    /**
     * Mark all unread notifications as read.
     */
    public function markAllRead()
    {
        Auth::user()
            ->unreadNotifications
            ->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read.',
        ]);
    }

    /**
     * Delete a single notification.
     */
    public function destroy(string $id)
    {
        $notification = Auth::user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted.',
        ]);
    }

    /**
     * Delete selected notifications.
     */
    public function deleteSelected(Request $request)
    {
        $notificationIds = $request->input('notifications', []);

        if (!is_array($notificationIds) || empty($notificationIds)) {
            return back();
        }

        Auth::user()
            ->notifications()
            ->whereIn('id', $notificationIds)
            ->delete();

        return back()->with(
            'success',
            'Selected notifications deleted.'
        );
    }

    /**
     * Open a notification.
     *
     * This marks the notification as read and redirects
     * the cadet to the page associated with the notification.
     */
    public function open(string $id)
    {
        $notification = Auth::user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Mark as read
        |--------------------------------------------------------------------------
        */

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        /*
        |--------------------------------------------------------------------------
        | Get notification data
        |--------------------------------------------------------------------------
        */

        $data = $notification->data ?? [];

        /*
        |--------------------------------------------------------------------------
        | 1. Preferred URL fields
        |--------------------------------------------------------------------------
        |
        | Your notification can contain:
        |
        | 'url'
        | 'action_url'
        | 'link'
        |
        */

        $url = $data['url']
            ?? $data['action_url']
            ?? $data['link']
            ?? null;

        /*
        |--------------------------------------------------------------------------
        | 2. If a route name was stored
        |--------------------------------------------------------------------------
        |
        | Example:
        |
        | 'route' => 'cadet.requirements'
        |
        */

        if (
            empty($url) &&
            !empty($data['route'])
        ) {
            try {
                $url = route($data['route']);
            } catch (\Throwable $e) {
                $url = null;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Determine destination from notification type
        |--------------------------------------------------------------------------
        */

        if (empty($url)) {

            $type = $data['type'] ?? null;

            switch ($type) {

                case 'requirement':
                case 'document':
                case 'document_status':
                    $url = route('cadet.requirements');
                    break;

                case 'onboard_requirement':
                case 'onboard_requirement_status':
                    $url = route('cadet.onboard.requirements');
                    break;

                case 'bs_requirement':
                case 'bs_requirement_status':
                    $url = route('cadet.bs.requirements');
                    break;

                case 'complaint':
                case 'complaint_status':
                    $url = route('cadet.complaints');
                    break;

                case 'deployment':
                case 'deployment_status':
                    $url = route('cadet.deployment');
                    break;

                case 'chat':
                case 'message':
                    $url = route('chat.index');
                    break;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Fallback based on notification title/message
        |--------------------------------------------------------------------------
        |
        | This allows older notifications that don't have a type/url
        | to still go somewhere useful.
        */

        if (empty($url)) {

            $title = strtolower(
                (string) ($data['title'] ?? '')
            );

            $message = strtolower(
                (string) (
                    $data['message']
                    ?? $data['body']
                    ?? ''
                )
            );

            $notificationText = $title . ' ' . $message;

            if (
                str_contains($notificationText, 'onboard')
            ) {
                $url = route('cadet.onboard.requirements');
            }

            elseif (
                str_contains($notificationText, 'bs requirement') ||
                str_contains($notificationText, 'b.s requirement')
            ) {
                $url = route('cadet.bs.requirements');
            }

            elseif (
                str_contains($notificationText, 'complaint') ||
                str_contains($notificationText, 'concern')
            ) {
                $url = route('cadet.complaints');
            }

            elseif (
                str_contains($notificationText, 'deployment')
            ) {
                $url = route('cadet.deployment');
            }

            elseif (
                str_contains($notificationText, 'chat') ||
                str_contains($notificationText, 'message')
            ) {
                $url = route('chat.index');
            }

            elseif (
                str_contains($notificationText, 'requirement') ||
                str_contains($notificationText, 'document')
            ) {
                $url = route('cadet.requirements');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Final fallback
        |--------------------------------------------------------------------------
        */

        if (empty($url)) {
            $url = route('cadet.notifications');
        }

        return redirect()->to($url);
    }
}