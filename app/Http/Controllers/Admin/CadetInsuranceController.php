<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\CadetInsurance;
use App\Models\User;
use App\Notifications\InsuranceExpirationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
            'expiry_warning_sent_at' => null,
            'expired_notified_at' => null,
        ];

        if ($insurance) {
            $insurance->update($data);
            $insurance->refresh();
        } else {
            $insurance = $cadet->insurance()->create($data);
        }

        if ($oldPath && $oldPath !== $path) {
            Storage::disk('local')->delete($oldPath);
        }

        // Send an expiration notification immediately when applicable.
        $this->notifyExpirationIfNeeded($insurance, $cadet);

        return redirect()
            ->route('admin.verification.show', $cadet->id)
            ->with('success', 'Insurance document and expiration date saved successfully.');
    }

    /**
     * Immediately notify administrators and the affected cadet
     * when the insurance expires within 30 days or has expired.
     */
    private function notifyExpirationIfNeeded(
        CadetInsurance $insurance,
        Cadet $cadet
    ): void {
        $expirationDate = Carbon::parse($insurance->expiration_date)->startOfDay();
        $today = today()->startOfDay();

        $admins = User::where('role', 'admin')->get();

        $cadetUser = $cadet->user;

        $cadetName = $cadet->full_name;

        // Already expired.
        if ($expirationDate->lte($today)) {

            if ($insurance->expired_notified_at) {
                return;
            }

            $title = 'Insurance Expired';
            $message = $cadetName . "'s insurance has expired.";

            $eventKey = 'insurance-expired-' .
                $insurance->id . '-' .
                $expirationDate->format('Ymd');

            $icon = 'fa-triangle-exclamation';

            $timestampColumn = 'expired_notified_at';

        } else {

            // Not yet expired, but within the next 30 days.
            if ($expirationDate->gt($today->copy()->addDays(30))) {
                return;
            }

            if ($insurance->expiry_warning_sent_at) {
                return;
            }

            $daysRemaining = (int) $today->diffInDays(
                $expirationDate,
                false
            );

            $title = 'Insurance Expiring Soon';

            $message = $cadetName .
                "'s insurance will expire in {$daysRemaining} day(s).";

            $eventKey = 'insurance-expiring-' .
                $insurance->id . '-' .
                $expirationDate->format('Ymd');

            $icon = 'fa-shield-halved';

            $timestampColumn = 'expiry_warning_sent_at';
        }

        $adminUrl = route('admin.verification.show', $cadet->id);
        $cadetUrl = route('dashboard');

        $notificationForAdmin = new InsuranceExpirationNotification(
            $title,
            $message,
            $icon,
            $adminUrl,
            $eventKey
        );

        $notificationForCadet = new InsuranceExpirationNotification(
            $title,
            $message,
            $icon,
            $cadetUrl,
            $eventKey
        );

        Notification::send($admins, $notificationForAdmin);

        if ($cadetUser) {
            $cadetUser->notify($notificationForCadet);
        }

        // Mark as notified so the scheduled command won't duplicate it.
        $insurance->update([
            $timestampColumn => now(),
        ]);
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
