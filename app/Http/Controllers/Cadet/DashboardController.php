<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Document;
use App\Models\CadetDocument;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use App\Models\Deployment;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        /*
        |--------------------------------------------------------------------------
        | CADET PROFILE
        |--------------------------------------------------------------------------
        */

        $cadet = Cadet::where('user_id', $userId)->first();

        /*
        |--------------------------------------------------------------------------
        | DEFAULT VALUES
        |--------------------------------------------------------------------------
        */

        $totalDocs = 0;
        $approvedDocs = 0;
        $progress = 0;

        $deploymentProgress = 0;
        $deploymentStatus = 'Not Deployed';

        /*
        |--------------------------------------------------------------------------
        | CADET DATA
        |--------------------------------------------------------------------------
        */

        if ($cadet) {

            /*
            |--------------------------------------------------------------------------
            | DOCUMENT VERIFICATION PROGRESS
            |--------------------------------------------------------------------------
            */

            $totalDocs = Document::where('is_required', 1)->count();

            $approvedDocs = CadetDocument::where('cadet_id', $cadet->id)
                ->where('status', 'Approved')
                ->count();

            $progress = $totalDocs > 0
                ? round(($approvedDocs / $totalDocs) * 100)
                : 0;


            /*
            |--------------------------------------------------------------------------
            | DEPLOYMENT
            |--------------------------------------------------------------------------
            */

            $deployment = Deployment::where('cadet_id', $cadet->id)
                ->latest()
                ->first();

            if ($deployment) {

                $deploymentProgress = $deployment->percentage ?? 0;

                $deploymentStatus = $deployment->status ?? 'Not Deployed';

            }

        }

        /*
        |--------------------------------------------------------------------------
        | COMPLAINTS
        |--------------------------------------------------------------------------
        */

        $openComplaints = Complaint::where('user_id', $userId)
            ->where('status', 'Open')
            ->count();

        $resolvedComplaints = Complaint::where('user_id', $userId)
            ->where('status', 'Resolved')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATIONS
        |--------------------------------------------------------------------------
        */

        $notifications = $user->notifications()
            ->latest()
            ->take(5)
            ->get();

        $unreadCount = $user->unreadNotifications()->count();


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(
            'progress',
            'deploymentProgress',
            'deploymentStatus',
            'approvedDocs',
            'totalDocs',
            'openComplaints',
            'resolvedComplaints',
            'notifications',
            'unreadCount'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | NOTIFICATIONS PAGE
    |--------------------------------------------------------------------------
    */

    public function notifications()
    {
        $user = Auth::user();

        $notifications = $user->notifications()
            ->latest()
            ->get();

        $user->unreadNotifications->markAsRead();

        return view(
            'cadet.notifications',
            compact('notifications')
        );
    }
}