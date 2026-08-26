<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Cadet;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use App\Events\CadetLocationUpdated;


class CadetController extends Controller
{
    public function index()
    {
        $cadets = Cadet::with(['user', 'batch', 'deployment'])
            ->orderBy('full_name')
            ->get();

        $batches = Batch::orderBy('batch_year', 'desc')->get();

        $courses = Cadet::select('course')
            ->whereNotNull('course')
            ->where('course', '!=', '')
            ->distinct()
            ->orderBy('course')
            ->get();

        $totalCadets = Cadet::count();

        return view('admin.cadets.index', [
            'cadets' => $cadets,
            'batches' => $batches,
            'courses' => $courses,
            'totalCadets' => $totalCadets,
            'activeCadets' => $totalCadets,
            'withDeployment' => Cadet::has('deployment')->count(),
            'noDeployment' => Cadet::doesntHave('deployment')->count(),
        ]);
    }

    public function create()
    {
        return view('admin.cadets.create', [
            'batches' => Batch::orderBy('batch_year', 'desc')->get(),
            'courses' => Course::orderBy('course_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'trb_control_number' => 'nullable|unique:cadets,trb_control_number',
            'full_name' => 'required|string',
            'course' => 'required|string',
            'batch_id' => 'required|exists:batches,id',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'required|string',
            'rank' => 'required|string',
            'address' => 'required|string',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if (Cadet::whereRaw(
            'LOWER(full_name) = ?',
            [strtolower(trim($request->full_name))]
        )->exists()) {
            return back()
                ->withInput()
                ->withErrors(['full_name' => 'This cadet already exists.']);
        }

        $photoPath = $request->hasFile('photo')
            ? $request->file('photo')->store('cadets', 'public')
            : null;

        try {
            Cadet::create([
                'trb_control_number' => $request->filled('trb_control_number')
                    ? $request->trb_control_number
                    : null,
                'full_name' => $request->full_name,
                'course' => $request->course,
                'batch_id' => $request->batch_id,
                'date_of_birth' => $request->date_of_birth,
                'place_of_birth' => $request->place_of_birth,
                'rank' => $request->rank,
                'address' => $request->address,
                'contact_number' => $request->contact_number,
                'email' => $request->email,
                'photo' => $photoPath,
                'parent_guardian_name' => trim(
                    $request->parent_first . ' ' .
                    $request->parent_middle . ' ' .
                    $request->parent_last
                ),
                'parent_guardian_contact' => $request->parent_contact,
                'parent_guardian_email' => $request->parent_email,
                'parent_guardian_address' => $request->parent_address,
                'verification_status' => 'Pending',
                'date_of_enrollment' => now(),
            ]);

            return redirect()
                ->route('admin.cadets.index')
                ->with('success', 'Cadet added successfully!');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'trb_control_number' =>
                            'TRB Control Number already exists. Please use a different one.'
                    ]);
            }

            throw $e;
        }
    }

    public function show(Cadet $cadet)
    {
        $cadet->load('batch');

        return view('admin.cadets.show', compact('cadet'));
    }

    public function edit(Cadet $cadet)
    {
        return view('admin.cadets.edit', [
            'cadet' => $cadet,
            'batches' => Batch::orderBy('batch_year', 'desc')->get(),
            'courses' => Course::orderBy('course_name')->get(),
        ]);
    }

    public function update(Request $request, Cadet $cadet)
    {
        $validated = $request->validate([
            'trb_control_number' => 'nullable|unique:cadets,trb_control_number,' . $cadet->id,
            'full_name' => 'required|string',
            'course' => 'required|string',
            'batch_id' => 'nullable|exists:batches,id',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string',
            'rank' => 'required|string',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'parent_guardian_name' => 'nullable|string',
            'parent_guardian_contact' => 'nullable|string',
            'parent_guardian_email' => 'nullable|email',
            'parent_guardian_address' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            if ($cadet->photo && Storage::disk('public')->exists($cadet->photo)) {
                Storage::disk('public')->delete($cadet->photo);
            }

            $validated['photo'] =
                $request->file('photo')->store('cadets', 'public');
        }

        $cadet->fill([
            'trb_control_number' => $validated['trb_control_number'],
            'full_name' => $validated['full_name'],
            'course' => $validated['course'],
            'batch_id' => $validated['batch_id'],
            'date_of_birth' => $validated['date_of_birth'],
            'place_of_birth' => $validated['place_of_birth'],
            'rank' => $validated['rank'],
            'address' => $validated['address'],
            'contact_number' => $validated['contact_number'],
            'email' => $validated['email'],
            'parent_guardian_name' => $validated['parent_guardian_name'] ?? null,
            'parent_guardian_contact' => $validated['parent_guardian_contact'] ?? null,
            'parent_guardian_email' => $validated['parent_guardian_email'] ?? null,
            'parent_guardian_address' => $validated['parent_guardian_address'] ?? null,
        ]);

        if (isset($validated['photo'])) {
            $cadet->photo = $validated['photo'];
        }

        $cadet->save();

        return redirect()
            ->route('admin.cadets.index')
            ->with('success', 'Cadet information updated successfully!');
    }

    public function destroy(Cadet $cadet)
    {
        if ($cadet->photo && Storage::disk('public')->exists($cadet->photo)) {
            Storage::disk('public')->delete($cadet->photo);
        }

        $cadet->delete();

        return redirect()
            ->route('admin.cadets.index')
            ->with('success', 'Cadet deleted successfully!');
    }

public function updateLocation(Request $request)
{
    try {

        /*
        |--------------------------------------------------------------------------
        | VALIDATE LOCATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
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
        ]);


        /*
        |--------------------------------------------------------------------------
        | AUTHENTICATED USER
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        if (!$user) {

            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);

        }


        /*
        |--------------------------------------------------------------------------
        | FIND CADET
        |--------------------------------------------------------------------------
        */

        $cadet = Cadet::where(
            'user_id',
            $user->id
        )
        ->with([
            'user',
            'deployment',
        ])
        ->first();


        if (!$cadet) {

            return response()->json([
                'success' => false,
                'message' => 'Cadet record not found.',
            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | CHECK ACTIVE DEPLOYMENT
        |--------------------------------------------------------------------------
        */

        $deployment = $cadet->deployment;


        if (!$deployment) {

            return response()->json([
                'success' => false,
                'message' => 'Cadet is not currently deployed.',
            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | CHECK DEPLOYMENT STATUS
        |--------------------------------------------------------------------------
        */

        if ($deployment->status !== 'Ongoing') {

            return response()->json([
                'success' => false,
                'message' =>
                    'Cadet deployment is not currently ongoing.',
            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE LOCATION
        |--------------------------------------------------------------------------
        */

        $cadet->latitude =
            (float) $validated['latitude'];

        $cadet->longitude =
            (float) $validated['longitude'];

        $cadet->last_seen =
            now();


        /*
        |--------------------------------------------------------------------------
        | SAVE
        |--------------------------------------------------------------------------
        */

        $cadet->save();


        /*
        |--------------------------------------------------------------------------
        | BROADCAST LOCATION
        |--------------------------------------------------------------------------
        */

        broadcast(
            new CadetLocationUpdated(

                cadetId:
                    (int) $cadet->id,

                fullName:
                    $cadet->full_name
                    ?? $cadet->user?->name
                    ?? 'Unknown Cadet',

                trbControlNumber:
                    $cadet->trb_control_number,

                course:
                    $cadet->course,

                latitude:
                    (float) $cadet->latitude,

                longitude:
                    (float) $cadet->longitude,

                lastSeen:
                    $cadet->last_seen
                        ? $cadet->last_seen->toDateTimeString()
                        : now()->toDateTimeString(),

                onlineStatus:
                    $cadet->online_status,

                photo:
                    $cadet->photo
            )
        );


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'message' =>
                'Location updated successfully.',

            'location' => [

                'latitude' =>
                    (float) $cadet->latitude,

                'longitude' =>
                    (float) $cadet->longitude,

                'last_seen' =>
                    $cadet->last_seen
                        ? $cadet->last_seen->toDateTimeString()
                        : null,

                'online_status' =>
                    $cadet->online_status,

            ],

        ]);

    } catch (\Throwable $e) {

        /*
        |--------------------------------------------------------------------------
        | LOG ERROR
        |--------------------------------------------------------------------------
        */

        \Log::error(
            'Cadet location update failed',
            [
                'user_id' => Auth::id(),
                'cadet_id' => $cadet->id ?? null,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]
        );


        return response()->json([

            'success' => false,

            'message' =>
                'Location update failed.',

            'error' =>
                config('app.debug')
                    ? $e->getMessage()
                    : 'Server error.',

        ], 500);

    }
}

    public function showLocation(int $id)
    {
        $cadet = Cadet::whereHas('deployment')->findOrFail($id);

        return view('admin.cadets.location', compact('cadet'));
    }
}