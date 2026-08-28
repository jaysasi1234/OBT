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
        'trb_control_number' => 'nullable|string|max:255',
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

        // Parent / Guardian
        'parent_first' => 'nullable|string|max:255',
        'parent_middle' => 'nullable|string|max:255',
        'parent_last' => 'nullable|string|max:255',
        'parent_contact' => 'nullable|string|max:20',
        'parent_email' => 'nullable|email',
        'parent_address' => 'nullable|string',
    ]);

    /*
    |--------------------------------------------------------------------------
    | CLEAN TRB CONTROL NUMBER
    |--------------------------------------------------------------------------
    */

    $trb = trim((string) $request->input('trb_control_number'));

    // Convert empty value to NULL
    $trb = $trb === '' ? null : $trb;


    /*
    |--------------------------------------------------------------------------
    | CHECK TRB DUPLICATE
    |--------------------------------------------------------------------------
    */

    if ($trb !== null) {

        $trbExists = Cadet::where(
            'trb_control_number',
            $trb
        )->exists();

        if ($trbExists) {

            return back()
                ->withInput()
                ->withErrors([
                    'trb_control_number' =>
                        'TRB Control Number already exists. Please use a different one.'
                ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CHECK DUPLICATE CADET NAME
    |--------------------------------------------------------------------------
    */

    $fullName = trim($request->input('full_name'));

    if (
        Cadet::whereRaw(
            'LOWER(TRIM(full_name)) = ?',
            [strtolower($fullName)]
        )->exists()
    ) {

        return back()
            ->withInput()
            ->withErrors([
                'full_name' =>
                    'This cadet already exists.'
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | PHOTO
    |--------------------------------------------------------------------------
    */

    $photoPath = $request->hasFile('photo')
        ? $request->file('photo')->store('cadets', 'public')
        : null;


    /*
    |--------------------------------------------------------------------------
    | PARENT / GUARDIAN INFORMATION
    |--------------------------------------------------------------------------
    */

    $parentGuardianName = trim(
        ($request->input('parent_first') ?? '') . ' ' .
        ($request->input('parent_middle') ?? '') . ' ' .
        ($request->input('parent_last') ?? '')
    );

    // Empty string becomes NULL
    $parentGuardianName = $parentGuardianName === ''
        ? null
        : $parentGuardianName;

    $parentGuardianContact = trim(
        (string) $request->input('parent_contact', '')
    );

    $parentGuardianContact = $parentGuardianContact === ''
        ? null
        : $parentGuardianContact;

    $parentGuardianEmail = trim(
        (string) $request->input('parent_email', '')
    );

    $parentGuardianEmail = $parentGuardianEmail === ''
        ? null
        : $parentGuardianEmail;

    $parentGuardianAddress = trim(
        (string) $request->input('parent_address', '')
    );

    $parentGuardianAddress = $parentGuardianAddress === ''
        ? null
        : $parentGuardianAddress;


    /*
    |--------------------------------------------------------------------------
    | CREATE CADET
    |--------------------------------------------------------------------------
    */

    try {

        $cadet = Cadet::create([

            'trb_control_number' => $trb,

            'full_name' => $fullName,

            'course' => $request->course,

            'batch_id' => $request->batch_id,

            'date_of_birth' => $request->date_of_birth,

            'place_of_birth' => $request->place_of_birth,

            'rank' => $request->rank,

            'address' => $request->address,

            'contact_number' => $request->contact_number,

            'email' => $request->email,

            'photo' => $photoPath,

            'parent_guardian_name' => $parentGuardianName,

            'parent_guardian_contact' => $parentGuardianContact,

            'parent_guardian_email' => $parentGuardianEmail,

            'parent_guardian_address' => $parentGuardianAddress,

            'verification_status' => 'Pending',

            'date_of_enrollment' => now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.cadets.index')
            ->with(
                'success',
                'Cadet added successfully!'
            );


    } catch (QueryException $e) {

        /*
        |--------------------------------------------------------------------------
        | TRB DUPLICATE FROM DATABASE
        |--------------------------------------------------------------------------
        */

        $message = $e->getMessage();

        if (
            str_contains(
                $message,
                'trb_control_number'
            )
            &&
            (
                str_contains(
                    $message,
                    'Duplicate entry'
                )
                ||
                str_contains(
                    $message,
                    '1062'
                )
            )
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'trb_control_number' =>
                        'TRB Control Number already exists. Please use a different one.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | LOG OTHER DATABASE ERRORS
        |--------------------------------------------------------------------------
        */

        \Log::error(
            'Cadet creation failed',
            [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | TEMPORARY DEVELOPMENT ERROR
        |--------------------------------------------------------------------------
        */

        return back()
            ->withInput()
            ->withErrors([
                'general' => $e->getMessage()
            ]);
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
        'trb_control_number' => 'nullable|string|max:255',
        'full_name' => 'required|string',
        'course' => 'required|string|max:255',
        'batch_id' => 'nullable|exists:batches,id',
        'date_of_birth' => 'nullable|date',
        'place_of_birth' => 'nullable|string',
        'rank' => 'required|string',
        'address' => 'nullable|string',
        'contact_number' => 'nullable|string|max:20',
        'email' => 'nullable|email',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        'guardian_relationship' => 'nullable|string|max:255',

        'parent_guardian_name' => 'nullable|string|max:255',
        'parent_guardian_contact' => 'nullable|string|max:20',
        'parent_guardian_email' => 'nullable|email',
        'parent_guardian_address' => 'nullable|string',
    ]);

    /*
    |--------------------------------------------------------------------------
    | CLEAN VALUES
    |--------------------------------------------------------------------------
    */

    $trb = trim((string) ($validated['trb_control_number'] ?? ''));
    $trb = $trb === '' ? null : $trb;

    $course = trim((string) ($validated['course'] ?? ''));

    /*
    |--------------------------------------------------------------------------
    | MAKE SURE COURSE IS NOT EMPTY
    |--------------------------------------------------------------------------
    */

    if ($course === '') {
        return back()
            ->withInput()
            ->withErrors([
                'course' => 'Please select a course.'
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK TRB DUPLICATE
    |--------------------------------------------------------------------------
    */

    if ($trb !== null) {

        $trbExists = Cadet::where(
            'trb_control_number',
            $trb
        )
        ->where('id', '!=', $cadet->id)
        ->exists();

        if ($trbExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'trb_control_number' =>
                        'TRB Control Number already exists. Please use a different one.'
                ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | PHOTO
    |--------------------------------------------------------------------------
    */

    if ($request->hasFile('photo')) {

        if (
            $cadet->photo &&
            Storage::disk('public')->exists($cadet->photo)
        ) {
            Storage::disk('public')->delete($cadet->photo);
        }

        $cadet->photo =
            $request->file('photo')->store('cadets', 'public');
    }

    /*
    |--------------------------------------------------------------------------
    | REMOVE PHOTO
    |--------------------------------------------------------------------------
    */

    if (
        $request->input('remove_photo') === '1' &&
        !$request->hasFile('photo')
    ) {

        if (
            $cadet->photo &&
            Storage::disk('public')->exists($cadet->photo)
        ) {
            Storage::disk('public')->delete($cadet->photo);
        }

        $cadet->photo = null;
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE CADET
    |--------------------------------------------------------------------------
    */

    $cadet->trb_control_number = $trb;

    $cadet->full_name =
        trim($validated['full_name']);

    $cadet->course =
        $course;

    $cadet->batch_id =
        $validated['batch_id'] ?? null;

    $cadet->date_of_birth =
        $validated['date_of_birth'] ?? null;

    $cadet->place_of_birth =
        $validated['place_of_birth'] ?? null;

    $cadet->rank =
        $validated['rank'];

    $cadet->address =
        $validated['address'] ?? null;

    $cadet->contact_number =
        $validated['contact_number'] ?? null;

    $cadet->email =
        $validated['email'] ?? null;

    $cadet->guardian_relationship =
        $validated['guardian_relationship'] ?? null;

    $cadet->parent_guardian_name =
        $validated['parent_guardian_name'] ?? null;

    $cadet->parent_guardian_contact =
        $validated['parent_guardian_contact'] ?? null;

    $cadet->parent_guardian_email =
        $validated['parent_guardian_email'] ?? null;

    $cadet->parent_guardian_address =
        $validated['parent_guardian_address'] ?? null;

    /*
    |--------------------------------------------------------------------------
    | SAVE
    |--------------------------------------------------------------------------
    */

    $cadet->save();

    /*
    |--------------------------------------------------------------------------
    | SUCCESS
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('admin.cadets.index')
        ->with(
            'success',
            'Cadet information updated successfully!'
        );
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