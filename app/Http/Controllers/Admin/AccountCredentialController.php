<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class AccountCredentialController extends Controller
{
    /**
     * =========================================================
     * ACCOUNT CREDENTIALS PAGE
     * =========================================================
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $batchId = $request->input('batch_id');

        /*
        |--------------------------------------------------------------------------
        | Batches
        |--------------------------------------------------------------------------
        */

        $batches = Batch::query()
            ->orderByDesc('id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Accounts
        |--------------------------------------------------------------------------
        */
        $users = User::query()
            ->with([
                'cadet.batch'
            ])
            ->when($search !== '', function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");

                });

            })
            ->when($batchId, function ($query) use ($batchId) {

                $query->whereHas('cadet', function ($q) use ($batchId) {

                    $q->where('batch_id', $batchId);

                });

            })
            ->orderBy('role')
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'username',
                'email',
                'role',
                'is_active',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Add batch information for Blade
        |--------------------------------------------------------------------------
        */

        $users->each(function ($user) {

            $user->batch_id =
                $user->cadet?->batch?->id;

            $user->batch_name =
                $user->cadet?->batch?->name
                ?? $user->cadet?->batch?->batch_name
                ?? $user->cadet?->batch?->year
                ?? null;
        });


        return view(
            'admin.settings.account-credentials',
            compact(
                'users',
                'batches',
                'search',
                'batchId'
            )
        );
    }


    /**
     * =========================================================
     * GENERATE CREDENTIALS FOR SELECTED ACCOUNTS
     * =========================================================
    */
    public function generate(Request $request)
    {
        $request->validate([
            'selected_user_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'selected_user_ids.*' => [
                'integer',
                'exists:users,id',
            ],
        ], [
            'selected_user_ids.required' =>
                'Please select at least one account.',

            'selected_user_ids.min' =>
                'Please select at least one account.',
        ]);


        $users = User::query()
            ->whereIn(
                'id',
                $request->input('selected_user_ids')
            )
            ->orderBy('name')
            ->get();


        if ($users->isEmpty()) {

            return redirect()
                ->route('admin.settings.account-credentials')
                ->with('error', 'No valid accounts were selected.');
        }


        $credentials = [];


        DB::transaction(function () use (
            $users,
            &$credentials
        ) {

            foreach ($users as $user) {

                /*
                |--------------------------------------------------------------------------
                | Generate username if missing
                |--------------------------------------------------------------------------
                */

                $username = $user->username;

                if (empty($username)) {

                    $username = $this->generateUniqueUsername(
                        $user->name,
                        $user->email,
                        $user->id
                    );

                    $user->username = $username;
                }


                /*
                |--------------------------------------------------------------------------
                | Generate temporary password
                |--------------------------------------------------------------------------
                */

                $temporaryPassword =
                    $this->generateTemporaryPassword();


                /*
                |--------------------------------------------------------------------------
                | Hash password
                |--------------------------------------------------------------------------
                */

                $user->password =
                    Hash::make($temporaryPassword);


                /*
                |--------------------------------------------------------------------------
                | Activate account
                |--------------------------------------------------------------------------
                */

                $user->is_active = true;


                /*
                |--------------------------------------------------------------------------
                | Save
                |--------------------------------------------------------------------------
                */

                $user->save();


                /*
                |--------------------------------------------------------------------------
                | Store credentials
                |--------------------------------------------------------------------------
                */

                $credentials[] = [

                    'id' =>
                        $user->id,

                    'name' =>
                        $user->name,

                    'username' =>
                        $username,

                    'email' =>
                        $user->email,

                    'role' =>
                        ucfirst($user->role),

                    'password' =>
                        $temporaryPassword,

                ];
            }
        });


        /*
        |--------------------------------------------------------------------------
        | Store generated credentials in session
        |--------------------------------------------------------------------------
        */

        session([
            'generated_credentials' => $credentials,
            'generated_at' => now()->toDateTimeString(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect back to Account Credentials page
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.settings.account-credentials')
            ->with(
                'success',
                count($credentials) .
                ' account credential(s) generated successfully.'
            );
    }

    public function download()
    {
        $credentials = session('generated_credentials');

        if (empty($credentials)) {
            return redirect()
                ->route('admin.settings.account-credentials')
                ->with('error', 'There are no generated credentials available for download.');
        }

        $pdf = Pdf::loadView(
            'admin.settings.account-credentials-pdf',
            [
                'credentials' => $credentials,
                'generatedAt' => session('generated_at')
                    ? \Carbon\Carbon::parse(session('generated_at'))
                    : now(),
            ]
        );

        $pdf->setPaper('a4', 'landscape');

        $filename =
            'account-credentials-' .
            now()->format('Y-m-d-His') .
            '.pdf';

        /*
        |--------------------------------------------------------------------------
        | Clear generated credentials after preparing PDF
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'generated_credentials',
            'generated_at',
        ]);

        return $pdf->download($filename);
    }


    /**
     * =========================================================
     * GENERATE UNIQUE USERNAME
     * =========================================================
     */
    private function generateUniqueUsername(
        string $name,
        ?string $email,
        int $userId
    ): string {

        /*
        |--------------------------------------------------------------------------
        | Prefer email username
        |--------------------------------------------------------------------------
        */

        if (
            !empty($email) &&
            str_contains($email, '@')
        ) {

            $emailUsername =
                explode(
                    '@',
                    $email
                )[0];

            $base =
                Str::slug(
                    $emailUsername,
                    ''
                );

        } else {

            $base =
                Str::slug(
                    $name,
                    ''
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Fallback
        |--------------------------------------------------------------------------
        */

        if (empty($base)) {

            $base = 'user';
        }


        /*
        |--------------------------------------------------------------------------
        | Limit length
        |--------------------------------------------------------------------------
        */

        $base =
            substr(
                $base,
                0,
                40
            );


        /*
        |--------------------------------------------------------------------------
        | Initial username
        |--------------------------------------------------------------------------
        */

        $username = $base;

        $counter = 1;


        /*
        |--------------------------------------------------------------------------
        | Check uniqueness
        |--------------------------------------------------------------------------
        */

        while (

            User::query()
                ->where(
                    'username',
                    $username
                )
                ->where(
                    'id',
                    '!=',
                    $userId
                )
                ->exists()

        ) {

            $username =
                $base .
                $counter;

            $counter++;
        }


        return $username;
    }


    /**
     * =========================================================
     * GENERATE TEMPORARY PASSWORD
     * =========================================================
     */
    private function generateTemporaryPassword(): string
    {
        return Str::random(14);
    }
}