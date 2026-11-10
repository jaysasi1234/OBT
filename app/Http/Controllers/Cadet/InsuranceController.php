<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InsuranceController extends Controller
{
    /**
     * Get the insurance belonging to the logged-in cadet.
     */
    private function getOwnInsurance()
    {
        $cadet = Cadet::where('user_id', Auth::id())
            ->firstOrFail();

        return $cadet->insurance()->firstOrFail();
    }

    /**
     * View the cadet's own insurance document.
     */
    public function view()
    {
        $insurance = $this->getOwnInsurance();

        abort_unless(
            Storage::disk('local')->exists($insurance->file_path),
            404,
            'Insurance document not found.'
        );

        $path = Storage::disk('local')->path($insurance->file_path);

        return response()->file($path, [
            'Content-Type' => $insurance->mime_type ?: 'application/octet-stream',
            'Content-Disposition' => 'inline; filename="' .
                basename($insurance->original_name) . '"',
        ]);
    }

    /**
     * Download the cadet's own insurance document.
     */
    public function download()
    {
        $insurance = $this->getOwnInsurance();

        abort_unless(
            Storage::disk('local')->exists($insurance->file_path),
            404,
            'Insurance document not found.'
        );

        return Storage::disk('local')->download(
            $insurance->file_path,
            basename($insurance->original_name)
        );
    }
}