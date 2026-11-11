<?php

namespace App\Http\Controllers;

use App\Models\DownloadableForm;
use Illuminate\Http\Request;
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
    | ADMIN: SHOW CREATE FORM
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.downloadable_forms.create');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN: SAVE NEW FORM
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

        DownloadableForm::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'is_published' => $request->boolean('is_published'),
            'uploaded_by' => \Illuminate\Support\Facades\Auth::id(),
        ]);

        return redirect()
            ->route('admin.downloadable-forms.index')
            ->with('success', 'Form uploaded successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN: SHOW EDIT FORM
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

            Storage::disk('local')->delete(
                $downloadableForm->file_path
            );

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
        Storage::disk('local')->delete($downloadableForm->file_path);

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
        $forms = DownloadableForm::where('is_published', true)
            ->latest()
            ->paginate(12);

        return view('cadet.downloadable_forms.index', compact('forms'));
    }

    /*
    |--------------------------------------------------------------------------
    | CADET: DOWNLOAD PUBLISHED FORM
    |--------------------------------------------------------------------------
    */

    public function download(DownloadableForm $downloadableForm)
    {
        abort_unless($downloadableForm->is_published, 404);

        abort_unless(
            Storage::disk('local')->exists($downloadableForm->file_path),
            404,
            'The requested file is no longer available.'
        );

        return Storage::disk('local')->download(
            $downloadableForm->file_path,
            $downloadableForm->original_name
        );
    }
}