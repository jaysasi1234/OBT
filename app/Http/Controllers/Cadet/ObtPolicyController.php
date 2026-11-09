<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ObtPolicyController extends Controller
{
    private string $policyKey = 'obt-manual-revision-03';

    private string $manualPath = 'obt-policies/obt-manual.docx';

    private string $pdfPath = 'obt-policies/obt-manual.pdf';

    /**
     * Allow authenticated cadets only.
     */
    private function ensureCadet(): void
    {
        abort_unless(
            Auth::check() && Auth::user()?->role === 'cadet',
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

        $pdfAvailable = Storage::disk('public')
            ->exists($this->pdfPath);

            dd([
    'controller' => self::class,
    'manual_path' => Storage::disk('public')->path($this->manualPath),
    'pdf_path' => Storage::disk('public')->path($this->pdfPath),
    'manual_available' => $manualAvailable,
    'pdf_available' => $pdfAvailable,
]);

        $acknowledgement = DB::table('obt_policy_acknowledgements')
            ->where('user_id', Auth::id())
            ->where('policy_key', $this->policyKey)
            ->first();

        return view('cadet.obt-policies.index', [
            'manualAvailable' => $manualAvailable,
            'pdfAvailable' => $pdfAvailable,
            'acknowledgement' => $acknowledgement,
        ]);
    }

    /**
     * Display PDF inside the browser.
     */
    public function preview()
    {
        $this->ensureCadet();

        abort_unless(
            Storage::disk('public')->exists($this->pdfPath),
            404,
            'The official OBT Manual PDF is not available.'
        );

        $filePath = Storage::disk('public')->path($this->pdfPath);

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="MMACI-Official-OBT-Manual.pdf"',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Download original Word manual.
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
     * Download PDF reading copy.
     */
    public function downloadPdf()
    {
        $this->ensureCadet();

        abort_unless(
            Storage::disk('public')->exists($this->pdfPath),
            404,
            'The official OBT Manual PDF is not available.'
        );

        return Storage::disk('public')->download(
            $this->pdfPath,
            'MMACI-Official-OBT-Manual.pdf'
        );
    }

    /**
     * Record cadet acknowledgement.
     */
    public function acknowledge()
    {
        $this->ensureCadet();

        abort_unless(
            Storage::disk('public')->exists($this->manualPath),
            404,
            'The official OBT Manual is not available.'
        );

        DB::table('obt_policy_acknowledgements')->updateOrInsert(
            [
                'user_id' => Auth::id(),
                'policy_key' => $this->policyKey,
            ],
            [
                'acknowledged_at' => now(),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return redirect()
            ->route('cadet.obt-policies.index')
            ->with(
                'success',
                'You have successfully acknowledged the OBT Manual.'
            );
    }
}