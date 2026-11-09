<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ObtPolicyController extends Controller
{
    /**
     * Current official manual revision.
     */
    private string $policyKey = 'obt-manual-revision-03';

    /**
     * Location of the official OBT Manual.
     */
    private string $manualPath = 'obt-policies/obt-manual.docx';

    /**
     * Make sure only cadets can access this page.
     */
    private function ensureCadet(): void
    {
        $user = Auth::user();

        abort_unless(
            $user !== null && $user->role === 'cadet',
            403
        );
    }

    /**
     * Display OBT Policies.
     */
    public function index()
    {
        $this->ensureCadet();

        $manualAvailable = Storage::disk('public')
            ->exists($this->manualPath);

        $acknowledgement = DB::table('obt_policy_acknowledgements')
            ->where('user_id', Auth::id())
            ->where('policy_key', $this->policyKey)
            ->first();

        return view('cadet.obt-policies.index', [
            'manualAvailable' => $manualAvailable,
            'acknowledgement' => $acknowledgement,
        ]);
    }

    /**
     * Download the official OBT Manual.
     */
    public function download()
    {
        $this->ensureCadet();

        abort_unless(
            Storage::disk('public')->exists($this->manualPath),
            404,
            'The official OBT Manual is not available.'
        );

        return Storage::disk('public')->download(
            $this->manualPath,
            'MMACI-Official-OBT-Manual.docx'
        );
    }

    /**
     * Record that the cadet has read the manual.
     */
    public function acknowledge()
    {
        $this->ensureCadet();

        abort_unless(
            Storage::disk('public')->exists($this->manualPath),
            404,
            'The official OBT Manual is not available.'
        );

        $now = now();

        $existing = DB::table('obt_policy_acknowledgements')
            ->where('user_id', Auth::id())
            ->where('policy_key', $this->policyKey)
            ->exists();

        DB::table('obt_policy_acknowledgements')->updateOrInsert(
            [
                'user_id' => Auth::id(),
                'policy_key' => $this->policyKey,
            ],
            [
                'acknowledged_at' => $now,
                'updated_at' => $now,
                ...($existing ? [] : ['created_at' => $now]),
            ]
        );

        return redirect()
            ->route('cadet.obt-policies.index')
            ->with('success', 'You have successfully acknowledged the OBT Manual.');
    }
}