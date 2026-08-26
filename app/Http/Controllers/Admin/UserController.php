<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cadet;
use App\Models\Course;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\AdminAccountCreated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // =========================================================
    // DISPLAY USERS
    // =========================================================

public function index()
{
    $users = User::with('cadet')
        ->latest()
        ->get();

    $courses = Course::orderBy('course_name')
        ->get();

    $batches = Batch::orderByDesc('batch_year')
        ->get();

    $cadets = Cadet::whereNull('user_id')
        ->orderBy('full_name')
        ->get();

    $cadetsByBatch = $cadets->groupBy('batch_id');

    $batchData = $batches->map(function ($batch) use ($cadetsByBatch) {

        return [
            'id' => $batch->id,

            'batch_year' => $batch->batch_year,

            'cadets' => ($cadetsByBatch[$batch->id] ?? collect())
                ->map(function ($cadet) {

                    return [
                        'id' => $cadet->id,
                        'name' => $cadet->full_name,
                        'trb' => $cadet->trb_control_number,
                    ];

                })
                ->values()
                ->toArray(),
        ];

    })
    ->values()
    ->toArray();

    return view('admin.users.index', compact(
        'users',
        'courses',
        'batches',
        'cadetsByBatch',
        'batchData'
    ));
}

// =========================================================
// CREATE ACCOUNTS FOR ENTIRE BATCH
// =========================================================
public function createBatchAccounts(Request $request)
{
    // ---------------------------------------------------------
    // Validate selected batch
    // ---------------------------------------------------------
    $request->validate([
        'batch_id' => [
            'required',
            'exists:batches,id',
        ],
    ], [
        'batch_id.required' => 'Please select a batch.',
        'batch_id.exists' => 'The selected batch does not exist.',
    ]);

    $batch = Batch::findOrFail($request->batch_id);

    // ---------------------------------------------------------
    // Get all cadets in the selected batch who do not yet
    // have a linked user account.
    // ---------------------------------------------------------
    $cadets = Cadet::where('batch_id', $batch->id)
        ->whereNull('user_id')
        ->orderBy('full_name')
        ->get();

    // ---------------------------------------------------------
    // Nothing to create
    // ---------------------------------------------------------
    if ($cadets->isEmpty()) {
        return back()->with(
            'error',
            'All cadets in this batch already have accounts.'
        );
    }

    $created = 0;
    $generatedEmails = 0;

    DB::transaction(function () use (
        $cadets,
        &$created,
        &$generatedEmails
    ) {

        foreach ($cadets as $cadet) {

            // -------------------------------------------------
            // Generate a clean username base from full name
            // -------------------------------------------------
            $baseUsername = Str::lower(
                preg_replace(
                    '/[^A-Za-z0-9]/',
                    '',
                    trim($cadet->full_name)
                )
            );

            $baseUsername = $baseUsername ?: 'cadet';

            // -------------------------------------------------
            // Generate unique username
            // -------------------------------------------------
            $username = $this->generateUniqueUsername(
                $baseUsername
            );

            // -------------------------------------------------
            // EMAIL HANDLING
            //
            // If the cadet already has an email:
            //     use the real email.
            //
            // If the cadet has NO email:
            //     generate a system email from the name.
            // -------------------------------------------------
            $email = trim((string) $cadet->email);

            if ($email === '') {

                $email = $this->generateCadetSystemEmail(
                    $cadet->full_name
                );

                $generatedEmails++;
            } else {

                // -------------------------------------------------
                // Extra protection:
                // Make sure an existing email is not already
                // attached to another user.
                // -------------------------------------------------
                if (
                    User::where('email', $email)->exists()
                ) {
                    continue;
                }
            }

            // -------------------------------------------------
            // Generate temporary password
            // -------------------------------------------------
            $temporaryPassword = Str::random(12);

            // -------------------------------------------------
            // Create user account
            // -------------------------------------------------
            $user = User::create([
                'name' => $cadet->full_name,

                'email' => $email,

                'username' => $username,

                'password' => Hash::make(
                    $temporaryPassword
                ),

                'role' => 'cadet',

                'course' => $cadet->course,

                'contact' => $cadet->contact_number,

                'trb_no' => $cadet->trb_control_number,

                'status' => 'active',

                'is_active' => true,

                'email_verified_at' => now(),
            ]);

            // -------------------------------------------------
            // Link the new user account to the cadet
            // -------------------------------------------------
            $cadet->update([
                'user_id' => $user->id,

                // Store the generated email back into the
                // cadet record so it is visible later.
                'email' => $email,
            ]);

            $created++;
        }
    });

    // ---------------------------------------------------------
    // Build result message
    // ---------------------------------------------------------
    $message =
        "{$created} cadet account(s) created successfully.";

    if ($generatedEmails > 0) {
        $message .=
            " {$generatedEmails} cadet(s) had no email address, "
            . "so the system generated account email addresses for them.";
    }

    return back()->with(
        'success',
        $message
    );
}

// =========================================================
// GENERATE SYSTEM EMAIL FOR CADET WITHOUT EMAIL
// =========================================================
private function generateCadetSystemEmail(string $fullName): string
{
    // ---------------------------------------------------------
    // Convert name into a clean email-safe value
    // Example:
    //
    // "Juan Dela Cruz"
    // becomes:
    // "juan.delacruz"
    // ---------------------------------------------------------
    $name = trim($fullName);

    $name = Str::lower($name);

    // Replace anything that is not a letter or number
    // with a space first.
    $name = preg_replace(
        '/[^a-z0-9]+/',
        ' ',
        $name
    );

    $parts = preg_split(
        '/\s+/',
        trim($name)
    );

    if (empty($parts)) {
        $base = 'cadet';
    } else {
        $firstName = $parts[0];

        $lastName = count($parts) > 1
            ? end($parts)
            : '';

        $base = $lastName
            ? $firstName . '.' . $lastName
            : $firstName;
    }

    $base = trim($base, '.');

    if ($base === '') {
        $base = 'cadet';
    }

    // ---------------------------------------------------------
    // Use your own system-only domain.
    //
    // IMPORTANT:
    // This is intentionally NOT a real email provider.
    // It is only an identifier for accounts that don't
    // have an actual email address.
    // ---------------------------------------------------------
    $domain = 'obt.local';

    $email = $base . '@' . $domain;

    $counter = 2;

    while (
        User::where('email', $email)->exists() ||
        Cadet::where('email', $email)->exists()
    ) {
        $email = $base . $counter . '@' . $domain;

        $counter++;
    }

    return $email;
}

    // =========================================================
    // CREATE CADET ACCOUNT
    // =========================================================

    public function createCadetAccount(Request $request)
    {
        $request->validate([
            'cadet_id' => [
                'required',
                'exists:cadets,id'
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],
        ]);

        $cadet = Cadet::findOrFail($request->cadet_id);

        if ($cadet->user_id) {
            return back()->withErrors([
                'cadet_id' => 'This cadet already has an account.'
            ]);
        }

        $names = preg_split('/\s+/', trim($cadet->full_name));

        $first = $names[0];

        $last = count($names) > 1
            ? end($names)
            : $first;

        $base = Str::lower(
            preg_replace('/[^A-Za-z0-9]/', '', $first . $last)
        );

        $username = $this->generateUniqueUsername($base);

        DB::transaction(function () use (
            $request,
            $cadet,
            $username
        ) {

            $user = User::create([
                'name' => $cadet->full_name,

                'email' => $request->email,

                'username' => $username,

                'password' => Hash::make($request->password),

                'role' => 'cadet',

                'course' => $cadet->course,

                'contact' => $cadet->contact_number,

                'trb_no' => $cadet->trb_control_number,

                'status' => 'active',

                'is_active' => true,

                'email_verified_at' => now(),
            ]);

            $cadet->update([
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
        });

        return back()->with(
            'success',
            'Cadet account created successfully.'
        );
    }


    // =========================================================
    // STORE USER
    // =========================================================

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => [
                'required',
                'string',
                'max:255'
            ],

            'last_name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],

            'role' => [
                'required',
                'in:dean,admin,cadet'
            ],

            'course' => [
                'nullable',
                'required_if:role,cadet'
            ],

            'trb_no' => [
                'nullable',
                'required_if:role,cadet',
                'string',
                'max:50',
                'unique:cadets,trb_control_number',
            ],

            'batch_id' => [
                'nullable',
                'exists:batches,id'
            ],

            'contact_number' => [
                'nullable',
                'string',
                'max:20'
            ],

            'status' => [
                'required',
                'in:active,inactive'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Generate Username
        |--------------------------------------------------------------------------
        */

        $base = Str::lower(
            preg_replace(
                '/[^A-Za-z0-9]/',
                '',
                $request->first_name . $request->last_name
            )
        );

        $username = $this->generateUniqueUsername($base);


        /*
        |--------------------------------------------------------------------------
        | ADMIN / DEAN
        |--------------------------------------------------------------------------
        |
        | Do NOT ask the creator to create the permanent password.
        | Generate a temporary random password and immediately send
        | the account setup email.
        |
        */

        $temporaryPassword = Str::random(32);


        /*
        |--------------------------------------------------------------------------
        | Create User
        |--------------------------------------------------------------------------
        */

        $user = DB::transaction(function () use (
            $request,
            $username,
            $temporaryPassword
        ) {

            $user = User::create([
                'name' => trim(
                    $request->first_name . ' ' . $request->last_name
                ),

                'email' => $request->email,

                'username' => $username,

                'password' => Hash::make($temporaryPassword),

                'role' => $request->role,

                'course' => $request->course,

                'contact' => $request->contact_number,

                'status' => $request->status,

                'trb_no' => $request->trb_no,

                'is_active' => $request->status === 'active',

                'email_verified_at' => now(),
            ]);


            /*
            |--------------------------------------------------------------------------
            | Automatically Create Cadet Profile
            |--------------------------------------------------------------------------
            */

            if ($request->role === 'cadet') {

                Cadet::create([
                    'user_id' => $user->id,

                    'trb_control_number' =>
                        $request->trb_no
                        ?? ('TRB-' . rand(10000, 99999)),

                    'full_name' => $user->name,

                    'course' => $request->course,

                    'batch_id' => $request->batch_id ?? null,

                    'date_of_birth' =>
                        $request->date_of_birth ?? null,

                    'place_of_birth' =>
                        $request->place_of_birth ?? null,

                    'rank' =>
                        $request->rank ?? null,

                    'address' =>
                        $request->address ?? null,

                    'contact_number' =>
                        $request->contact_number ?? 'N/A',

                    'email' => $user->email,
                ]);
            }

            return $user;
        });


        /*
        |--------------------------------------------------------------------------
        | Send Admin / Dean Account Email
        |--------------------------------------------------------------------------
        */

        $emailSent = false;

        if (in_array($user->role, ['admin', 'dean'])) {
            
        
        try {
            /** @var \Illuminate\Auth\Passwords\PasswordBroker $broker */
                        $broker = Password::broker();

                        $token = $broker->createToken($user);


                Mail::to($user->email)->send(
                    new AdminAccountCreated(
                        $user,
                        $token
                    )
                );

                $emailSent = true;

            } catch (\Throwable $e) {

                Log::error('Account setup email failed', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error' => $e->getMessage(),
                ]);
            }
        }


// =========================================================
// Success / Email Status Message
// =========================================================

$roleName = ucfirst($user->role);

// Admin / Dean
if (in_array($user->role, ['admin', 'dean'])) {

    if ($emailSent) {

        return back()->with(
            'success',
            "{$roleName} account created successfully. "
            . "An account setup email has been sent to {$user->email}."
        );

    }

    return back()->withErrors([
        'email' =>
            "{$roleName} account was created, but the setup email "
            . "could not be sent. Please check the mail configuration."
    ]);
}

// Cadet
return back()->with(
    'success',
    "{$roleName} account created successfully."
);
    }


    // =========================================================
    // UPDATE USER
    // =========================================================

    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email,' . $id
            ],

            'role' => [
                'required',
                'in:dean,admin,cadet'
            ],

            'is_active' => [
                'required'
            ],
        ]);


        $oldEmail = $user->email;
        $oldRole = $user->role;


        $user->update([
            'name' => $request->name,

            'email' => $request->email,

            'role' => $request->role,

            'is_active' => $request->is_active,

            'status' =>
                $request->is_active
                ? 'active'
                : 'inactive',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Update Cadet Profile
        |--------------------------------------------------------------------------
        */

        $cadet = Cadet::where(
            'user_id',
            $user->id
        )->first();


        if ($cadet) {

            $cadet->update([
                'full_name' => $request->name,

                'email' => $request->email,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | If Admin/Dean Email Changed
        |--------------------------------------------------------------------------
        */

        if (
            in_array($user->role, ['admin', 'dean']) &&
            $oldEmail !== $user->email
        ) {

            /*
            | Send notification here if desired.
            */
        }


        return back()->with(
            'success',
            'User updated successfully!'
        );
    }


    // =========================================================
    // DELETE USER
    // =========================================================

    public function destroy(int $id)
    {
        $user = User::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Prevent Accidental Self Deletion
        |--------------------------------------------------------------------------
        */

        if (Auth::id() === $user->id) {

            return back()->withErrors([
                'user' =>
                    'You cannot delete your own account.'
            ]);
        }


        $user->delete();

        return back()->with(
            'success',
            'User deleted successfully!'
        );
    }


    // =========================================================
    // GENERATE UNIQUE USERNAME
    // =========================================================

    private function generateUniqueUsername(string $base): string
    {
        $base = $base ?: 'user';

        do {

            $username =
                $base .
                rand(1000, 9999);

        } while (
            User::where(
                'username',
                $username
            )->exists()
        );

        return $username;
    }
}