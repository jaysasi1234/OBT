<?php

namespace App\Http\Controllers;

use App\Events\CadetLocationUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CadetLocationController extends Controller
{
    public function update(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate GPS data
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
            ],

            'accuracy' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Get authenticated user
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Get cadet record
        |--------------------------------------------------------------------------
        */

        $cadet = $user->cadet;

        if (!$cadet) {
            return response()->json([
                'success' => false,
                'message' => 'Cadet record not found.',
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Check CURRENT deployment
        |--------------------------------------------------------------------------
        |
        | Only an Ongoing deployment is allowed to send GPS location.
        |
        */

        $deployment = $cadet->deployments()
            ->where('status', 'Ongoing')
            ->latest()
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Cadet is NOT currently deployed
        |--------------------------------------------------------------------------
        */

        if (!$deployment) {

            /*
            | Clear old GPS coordinates so the admin map
            | will not continue showing this cadet.
            */

            $cadet->latitude = null;
            $cadet->longitude = null;
            $cadet->location_accuracy = null;
            $cadet->location_updated_at = null;

            $cadet->save();

            return response()->json([
                'success' => false,
                'message' => 'Cadet is not currently deployed.',
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | Save current location
        |--------------------------------------------------------------------------
        */

        $cadet->latitude = (float) $request->latitude;

        $cadet->longitude = (float) $request->longitude;

        $cadet->location_accuracy = $request->accuracy !== null
            ? (float) $request->accuracy
            : null;

        $cadet->location_updated_at = now();

        $cadet->save();

        /*
        |--------------------------------------------------------------------------
        | Refresh cadet
        |--------------------------------------------------------------------------
        */

        $cadet->refresh();

        /*
        |--------------------------------------------------------------------------
        | Prepare last seen timestamp
        |--------------------------------------------------------------------------
        */

        $lastSeen = $cadet->location_updated_at;

        if ($lastSeen instanceof \Carbon\CarbonInterface) {

            $lastSeen = $lastSeen->toISOString();

        } elseif ($lastSeen) {

            $lastSeen = (string) $lastSeen;

        } else {

            $lastSeen = now()->toISOString();
        }

        /*
        |--------------------------------------------------------------------------
        | Broadcast location update
        |--------------------------------------------------------------------------
        */

        broadcast(
            new CadetLocationUpdated(
                (int) $cadet->id,

                (string) $cadet->full_name,

                $cadet->trb_control_number !== null
                    ? (string) $cadet->trb_control_number
                    : null,

                $cadet->course !== null
                    ? (string) $cadet->course
                    : null,

                $cadet->latitude !== null
                    ? (float) $cadet->latitude
                    : null,

                $cadet->longitude !== null
                    ? (float) $cadet->longitude
                    : null,

                $lastSeen,

                'online',

                $cadet->photo !== null
                    ? (string) $cadet->photo
                    : null
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Return response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'message' => 'Location updated successfully.',

            'latitude' => (float) $cadet->latitude,

            'longitude' => (float) $cadet->longitude,

            'accuracy' => $cadet->location_accuracy !== null
                ? (float) $cadet->location_accuracy
                : null,

            'updated_at' => $lastSeen,
        ]);
    }
}