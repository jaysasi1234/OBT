<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * Get the original DOCX path.
     */
    private function manualFilePath(): string
    {
        return public_path($this->manualPath);
    }

    /**
     * Get the PDF path.
     */
    private function pdfFilePath(): string
    {
        return public_path($this->pdfPath);
    }

    /**
     * Display OBT Policies.
     */
    public function index()
    {
        $this->ensureCadet();

        $manualAvailable = is_file($this->manualFilePath());

        $pdfAvailable = is_file($this->pdfFilePath());

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

    $filePath = $this->pdfFilePath();

    abort_unless(
        is_file($filePath) && is_readable($filePath),
        404,
        'The official OBT Manual PDF is not available.'
    );

    return response()->stream(function () use ($filePath) {
        $handle = fopen($filePath, 'rb');

        if ($handle === false) {
            abort(500, 'Unable to read the OBT Manual PDF.');
        }

        fpassthru($handle);
        fclose($handle);

    }, 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="MMACI-Official-OBT-Manual.pdf"',
        'Content-Length' => filesize($filePath),
        'Accept-Ranges' => 'bytes',
        'X-Content-Type-Options' => 'nosniff',
        'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
    ]);
}

    /**
     * Download original Word manual.
     */
    public function download()
    {
        $this->ensureCadet();

        $filePath = $this->manualFilePath();

        abort_unless(
            is_file($filePath),
            404,
            'The official OBT Manual is not available.'
        );

        return response()->download(
            $filePath,
            'MMACI-Official-OBT-Manual.docx'
        );
    }

    /**
     * Download PDF reading copy.
     */
    public function downloadPdf()
    {
        $this->ensureCadet();

        $filePath = $this->pdfFilePath();

        abort_unless(
            is_file($filePath),
            404,
            'The official OBT Manual PDF is not available.'
        );

        return response()->download(
            $filePath,
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
            is_file($this->manualFilePath()),
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