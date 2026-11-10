<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Document;
use App\Models\CadetDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\VerificationRequirementUploadedNotification;

class RequirementController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | 1. GET LOGGED-IN CADET
        |--------------------------------------------------------------------------
        */

        $cadet = Cadet::where('user_id', Auth::id())->first();

        /*
        |--------------------------------------------------------------------------
        | 2. CHECK IF CADET EXISTS
        |--------------------------------------------------------------------------
        */

        if (!$cadet) {
            return view('cadet.requirements', [
                'documents' => collect(),
                'cadetDocs' => collect(),

                'total' => 0,
                'approved' => 0,
                'submitted' => 0,
                'pending' => 0,
                'rejected' => 0,

                // No insurance record
                'insurance' => null,

            ])->with('error', 'Cadet profile not found. Please contact admin.');
        }

        /*
        |--------------------------------------------------------------------------
        | 3. GET CADET INSURANCE
        |--------------------------------------------------------------------------
        |
        | This is separate from Verification Requirements.
        | It does not affect requirement statistics or approval status.
        |
        */

        $insurance = $cadet->insurance;

        /*
        |--------------------------------------------------------------------------
        | 4. GET REQUIRED DOCUMENTS
        |--------------------------------------------------------------------------
        */

        $documents = Document::all();

        /*
        |--------------------------------------------------------------------------
        | 5. GET CADET SUBMITTED DOCUMENTS
        |--------------------------------------------------------------------------
        */

        $cadetDocs = CadetDocument::where('cadet_id', $cadet->id)
            ->get()
            ->keyBy('document_id');

        /*
        |--------------------------------------------------------------------------
        | 6. COMPUTE EXISTING REQUIREMENT STATISTICS
        |--------------------------------------------------------------------------
        */

        $total = $documents->count();

        $approved = $cadetDocs->where('status', 'Approved')->count();

        $submitted = $cadetDocs->where('status', 'Submitted')->count();

        $pending = $cadetDocs->where('status', 'Pending')->count();

        $rejected = $cadetDocs->where('status', 'Rejected')->count();

        /*
        |--------------------------------------------------------------------------
        | 7. RETURN CADET REQUIREMENTS PAGE
        |--------------------------------------------------------------------------
        */

        return view('cadet.requirements', compact(
            'documents',
            'cadetDocs',
            'total',
            'approved',
            'submitted',
            'pending',
            'rejected',
            'insurance'
        ));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        /*
        |--------------------------------------------------------------------------
        | FIND CADET
        |--------------------------------------------------------------------------
        */

        $cadet = Cadet::where(
            'user_id',
            Auth::id()
        )->first();

        if (!$cadet) {
            return back()->with('error', 'Cadet profile not found.');
        }

        /*
        |--------------------------------------------------------------------------
        | FIND DOCUMENT
        |--------------------------------------------------------------------------
        */

        $document = Document::findOrFail(
            $request->document_id
        );

        /*
        |--------------------------------------------------------------------------
        | STORE FILE
        |--------------------------------------------------------------------------
        */

        $path = $request
            ->file('file')
            ->store('requirements', 'public');

        /*
        |--------------------------------------------------------------------------
        | CREATE / UPDATE SUBMISSION
        |--------------------------------------------------------------------------
        */

        CadetDocument::updateOrCreate(
            [
                'cadet_id' => $cadet->id,
                'document_id' => $request->document_id,
            ],
            [
                'file_path' => $path,
                'status' => 'Submitted',
                'remarks' => null,
                'submitted_at' => now(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | NOTIFY ADMINS
        |--------------------------------------------------------------------------
        */

        $admins = User::whereIn(
            'role',
            [
                'Admin',
                'Super Admin',
            ]
        )->get();

        foreach ($admins as $admin) {
            $admin->notify(
                new VerificationRequirementUploadedNotification(
                    $cadet,
                    $document
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            'Requirement uploaded successfully.'
        );
    }
}