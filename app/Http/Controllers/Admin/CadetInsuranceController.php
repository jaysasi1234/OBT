<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CadetInsuranceController extends Controller
{
    /**
     * Upload or replace a cadet's insurance document.
     */
    public function store(Request $request, Cadet $cadet)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'expiration_date' => 'required|date',
        ], [
            'file.required' => 'Please select an insurance document.',
            'file.mimes' => 'Only PDF, JPG, JPEG, and PNG files are accepted.',
            'file.max' => 'The insurance document must not exceed 10 MB.',
            'expiration_date.required' => 'Please select the insurance expiration date.',
            'expiration_date.date' => 'Please enter a valid expiration date.',
        ]);

        // Store privately.
        $file = $request->file('file');

        $path = $file->store('cadet-insurances', 'local');

        $insurance = $cadet->insurance()->first();

        $oldPath = $insurance?->file_path;

        $data = [
            'uploaded_by' => Auth::id(),
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'expiration_date' => $validated['expiration_date'],

            // Reset notifications when the insurance is replaced.
            'expiry_warning_sent_at' => null,
            'expired_notified_at' => null,
        ];

        if ($insurance) {
            $insurance->update($data);
        } else {
            $cadet->insurance()->create($data);
        }

        // Delete the previous file after successfully saving the new record.
        if ($oldPath && $oldPath !== $path) {
            Storage::disk('local')->delete($oldPath);
        }

        return redirect()
            ->route('admin.verification.show', $cadet->id)
            ->with('success', 'Insurance document and expiration date saved successfully.');
    }

    /**
     * View a cadet's insurance document.
     */
    public function view(Cadet $cadet)
    {
        $insurance = $cadet->insurance()->firstOrFail();

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
     * Download a cadet's insurance document.
     */
    public function download(Cadet $cadet)
    {
        $insurance = $cadet->insurance()->firstOrFail();

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

    /**
     * Delete a cadet's insurance document.
     */
    public function destroy(Cadet $cadet)
    {
        $insurance = $cadet->insurance()->firstOrFail();

        $path = $insurance->file_path;

        $insurance->delete();

        Storage::disk('local')->delete($path);

        return redirect()
            ->route('admin.verification.show', $cadet->id)
            ->with('success', 'Insurance document deleted successfully.');
    }
}
