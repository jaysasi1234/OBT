<?php

namespace App\Http\Controllers;

use App\Models\DownloadableForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DownloadableFormController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN: LIST ALL FORMS
    |--------------------------------------------------------------------------
    */

    public function adminIndex()
    {
        $forms = DownloadableForm::with('uploader')
            ->latest()
            ->paginate(15);

        $totalForms = DownloadableForm::count();

        $publishedForms = DownloadableForm::where('is_published', true)
            ->count();

        $draftForms = DownloadableForm::where('is_published', false)
            ->count();

        return view('admin.downloadable_forms.index', compact(
            'forms',
            'totalForms',
            'publishedForms',
            'draftForms'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN: CREATE FORM
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.downloadable_forms.create');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN: STORE FORM
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'file' => [
                'required',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx',
                'max:20480',
            ],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $file = $request->file('file');

        $path = $file->store('downloadable-forms', 'local');

        if (!$path) {
            return back()
                ->withInput()
                ->with('error', 'Unable to upload the file. Please try again.');
        }

        DownloadableForm::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'is_published' => $request->boolean('is_published'),
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()
            ->route('admin.downloadable-forms.index')
            ->with('success', 'Form uploaded successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN: EDIT FORM
    |--------------------------------------------------------------------------
    */

    public function edit(DownloadableForm $downloadableForm)
    {
        return view('admin.downloadable_forms.edit', compact(
            'downloadableForm'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN: UPDATE FORM
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        DownloadableForm $downloadableForm
    ) {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'file' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx',
                'max:20480',
            ],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'is_published' => $request->boolean('is_published'),
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $newPath = $file->store('downloadable-forms', 'local');

            if (!$newPath) {
                return back()
                    ->withInput()
                    ->with('error', 'Unable to upload the replacement file.');
            }

            // Delete the previous file only after the new file is stored.
            if ($downloadableForm->file_path) {
                Storage::disk('local')->delete(
                    $downloadableForm->file_path
                );
            }

            $data['file_path'] = $newPath;
            $data['original_name'] = $file->getClientOriginalName();
            $data['mime_type'] = $file->getMimeType();
            $data['file_size'] = $file->getSize();
        }

        $downloadableForm->update($data);

        return redirect()
            ->route('admin.downloadable-forms.index')
            ->with('success', 'Form updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN: DELETE FORM
    |--------------------------------------------------------------------------
    */

    public function destroy(DownloadableForm $downloadableForm)
    {
        if ($downloadableForm->file_path) {
            Storage::disk('local')->delete(
                $downloadableForm->file_path
            );
        }

        $downloadableForm->delete();

        return redirect()
            ->route('admin.downloadable-forms.index')
            ->with('success', 'Form deleted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | CADET: VIEW PUBLISHED FORMS
    |--------------------------------------------------------------------------
    */

    public function cadetIndex()
    {
        try {
            $forms = DownloadableForm::query()
                ->where('is_published', true)
                ->orderByDesc('created_at')
                ->simplePaginate(12);

            return view('cadet.downloadable_forms.index', compact('forms'));

        } catch (\Throwable $e) {
            Log::error('Cadet Downloadable Forms Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CADET: DOWNLOAD PUBLISHED FORM
    |--------------------------------------------------------------------------
    */

    public function download(DownloadableForm $downloadableForm)
    {
        abort_unless($downloadableForm->is_published, 404);

        $disk = Storage::disk('local');

        abort_unless(
            $downloadableForm->file_path &&
            $disk->exists($downloadableForm->file_path),
            404,
            'The requested file is no longer available.'
        );

        return $disk->download(
            $downloadableForm->file_path,
            $downloadableForm->original_name
                ?: basename($downloadableForm->file_path)
        );
    }
}
