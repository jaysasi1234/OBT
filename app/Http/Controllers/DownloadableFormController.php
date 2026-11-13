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
    | GET LOGGED-IN CADET COURSE
    |--------------------------------------------------------------------------
    */

    private function getCadetCourse(): ?string
    {
        $user = Auth::user();

        if (!$user) {
            return null;
        }

        // Cadet record is the primary source.
        $course = $user->cadet?->course;

        // Fallback to the User course column.
        $course = $course ?: $user->course;

        $course = strtoupper(trim((string) $course));

        return in_array($course, ['BSMT', 'BSMARE'], true)
            ? $course
            : null;
    }

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

            'course_target' => [
                'required',
                'in:all,BSMT,BSMARE',
            ],

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
            'course_target' => $validated['course_target'],
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

            'course_target' => [
                'required',
                'in:all,BSMT,BSMARE',
            ],

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
            'course_target' => $validated['course_target'],
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

            // Delete the old file only after successful replacement.
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
    | CADET: VIEW PUBLISHED FORMS FOR THEIR COURSE
    |--------------------------------------------------------------------------
    */

    public function cadetIndex()
    {
        try {
            $course = $this->getCadetCourse();

            $forms = DownloadableForm::query()
                ->where('is_published', true)
                ->where(function ($query) use ($course) {

                    // All-cadet forms are always visible.
                    $query->where('course_target', 'all');

                    // Show forms specifically assigned to this course.
                    if ($course) {
                        $query->orWhere('course_target', $course);
                    }

                })
                ->orderByDesc('created_at')
                ->simplePaginate(12);

            return view(
                'cadet.downloadable_forms.index',
                compact('forms', 'course')
            );

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
        // Draft documents cannot be downloaded.
        abort_unless($downloadableForm->is_published, 404);

        $course = $this->getCadetCourse();

        // Check course authorization even when a cadet manually
        // enters another form's download URL.
        $isForAll = $downloadableForm->course_target === 'all';

        $isForCadetCourse = $course !== null
            && $downloadableForm->course_target === $course;

        abort_unless(
            $isForAll || $isForCadetCourse,
            404
        );

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
