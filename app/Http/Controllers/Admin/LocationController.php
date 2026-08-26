<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use Carbon\Carbon;

class LocationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOCATION MAP PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $cadets = Cadet::with([
                'deployment',
                'user',
            ])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($cadet) {

                return $this->normalizeCadet($cadet);

            });

        return view(
            'admin.locations',
            compact('cadets')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REALTIME LOCATION DATA
    |--------------------------------------------------------------------------
    */

    public function data()
    {
        $cadets = Cadet::with([
                'deployment',
                'user',
            ])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($cadet) {

                return $this->normalizeCadet($cadet);

            });

        return response()->json(
            $cadets->values()
        );
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE CADET DATA
    |--------------------------------------------------------------------------
    |
    | This ensures the Blade always receives the same payload structure.
    |
    */

    private function normalizeCadet(Cadet $cadet): array
    {
        /*
        |--------------------------------------------------------------------------
        | LAST SEEN
        |--------------------------------------------------------------------------
        */

        $lastSeen = null;

        if ($cadet->last_seen) {

            try {

                $lastSeen = $cadet->last_seen instanceof Carbon
                    ? $cadet->last_seen
                    : Carbon::parse($cadet->last_seen);

            } catch (\Throwable $e) {

                $lastSeen = null;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | DETERMINE ONLINE STATUS
        |--------------------------------------------------------------------------
        |
        | A cadet is considered active when their GPS location was updated
        | recently.
        |
        | This prevents the map from saying "Online" forever if the cadet
        | closes the browser or loses their connection.
        |
        */

        $onlineStatus = 'offline';


        if ($lastSeen) {

            $secondsSinceLastSeen =
                $lastSeen->diffInSeconds(now());


            /*
            |--------------------------------------------------------------------------
            | ACTIVE
            |--------------------------------------------------------------------------
            |
            | GPS update within the last 60 seconds.
            |
            */

            if ($secondsSinceLastSeen <= 60) {

                $onlineStatus = 'active';

            }


            /*
            |--------------------------------------------------------------------------
            | IDLE
            |--------------------------------------------------------------------------
            |
            | GPS update between 61 and 180 seconds ago.
            |
            */

            elseif ($secondsSinceLastSeen <= 180) {

                $onlineStatus = 'idle';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | FALLBACK TO DATABASE STATUS
        |--------------------------------------------------------------------------
        |
        | If there is no usable last_seen timestamp yet, use the stored
        | online_status value.
        |
        */

        if (!$lastSeen) {

            $storedStatus = strtolower(
                trim(
                    (string) (
                        $cadet->online_status
                        ?? ''
                    )
                )
            );


            if (
                in_array(
                    $storedStatus,
                    [
                        'online',
                        'active',
                        'connected',
                    ],
                    true
                )
            ) {

                $onlineStatus = 'active';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | USER ONLINE FALLBACK
        |--------------------------------------------------------------------------
        |
        | If your users table contains is_online, use it only as a fallback.
        |
        */

        if (
            $onlineStatus === 'offline' &&
            $cadet->user
        ) {

            $userOnline =
                $cadet->user->is_online ?? false;


            if (
                $userOnline === true ||
                $userOnline === 1 ||
                $userOnline === '1'
            ) {

                /*
                 * The account is online, but we do not have a recent
                 * GPS heartbeat. Mark it as active so the admin map
                 * reflects the current logged-in state.
                 */

                $onlineStatus = 'active';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | PHOTO URL
        |--------------------------------------------------------------------------
        */

        $photo = $cadet->photo;


        /*
        |--------------------------------------------------------------------------
        | RETURN NORMALIZED PAYLOAD
        |--------------------------------------------------------------------------
        */

        return [

            /*
            |--------------------------------------------------------------------------
            | IDENTIFIERS
            |--------------------------------------------------------------------------
            */

            'id' =>
                (int) $cadet->id,

            'cadet_id' =>
                (int) $cadet->id,

            'user_id' =>
                $cadet->user_id
                    ? (int) $cadet->user_id
                    : null,


            /*
            |--------------------------------------------------------------------------
            | BASIC INFORMATION
            |--------------------------------------------------------------------------
            */

            'full_name' =>
                $cadet->full_name
                ?? $cadet->user?->name
                ?? 'Unknown Cadet',

            'trb_control_number' =>
                $cadet->trb_control_number,

            'course' =>
                $cadet->course,


            /*
            |--------------------------------------------------------------------------
            | LOCATION
            |--------------------------------------------------------------------------
            */

            'latitude' =>
                is_numeric($cadet->latitude)
                    ? (float) $cadet->latitude
                    : null,

            'longitude' =>
                is_numeric($cadet->longitude)
                    ? (float) $cadet->longitude
                    : null,


            /*
            |--------------------------------------------------------------------------
            | ONLINE / REALTIME
            |--------------------------------------------------------------------------
            */

            'online_status' =>
                $onlineStatus,

            'is_online' =>
                $onlineStatus === 'active',

            'last_seen' =>
                $lastSeen
                    ? $lastSeen->toDateTimeString()
                    : null,


            /*
            |--------------------------------------------------------------------------
            | PROFILE PHOTO
            |--------------------------------------------------------------------------
            */

            'photo' =>
                $photo,


            /*
            |--------------------------------------------------------------------------
            | DEPLOYMENT
            |--------------------------------------------------------------------------
            */

            'deployment' =>
                $cadet->deployment,
        ];
    }
}