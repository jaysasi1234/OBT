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
        // 1. Get logged-in user cadet profile
        $cadet = Cadet::where('user_id', Auth::id())->first();

        // 2. If cadet does NOT exist, still allow page to open safely
        if (!$cadet) {

            return view('cadet.requirements', [
                'documents' => collect(),
                'cadetDocs' => collect(),

                'total' => 0,
                'approved' => 0,
                'pending' => 0,
                'rejected' => 0,
            ])->with('error', 'Cadet profile not found. Please contact admin.');
        }

        // 3. Get all required documents (from admin)
        $documents = Document::all();

        // 4. Get cadet submitted documents
        $cadetDocs = CadetDocument::where('cadet_id', $cadet->id)
            ->get()
            ->keyBy('document_id');

        // 5. COMPUTE STATS
        $total = $documents->count();

        $approved = $cadetDocs->where('status', 'Approved')->count();

        $submitted = $cadetDocs->where('status', 'Submitted')->count();

        $pending = $cadetDocs->where('status', 'Pending')->count();

        $rejected = $cadetDocs->where('status', 'Rejected')->count();

         // 6. RETURN VIEW
        return view('cadet.requirements', compact(
            'documents',
            'cadetDocs',
            'total',
            'approved',
            'submitted',
            'pending',
            'rejected'
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

        return back()
            ->with('error', 'Cadet profile not found.');
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

    $cadetDocument = CadetDocument::updateOrCreate(

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

    return back()
        ->with(
            'success',
            'Requirement uploaded successfully.'
        );
}
}