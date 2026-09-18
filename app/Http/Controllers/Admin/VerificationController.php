<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Batch;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Notifications\VerificationRequirementStatusNotification;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller
{
    // =========================================================
    // INDEX
    // =========================================================

    public function index(Request $request)
    {
        $query = Cadet::with([
            'batch',
            'documents',
            'bsRequirements'
        ])
        ->orderByRaw('LOWER(full_name) ASC');


        // =====================================================
        // FILTERS
        // =====================================================

        if ($request->course) {

            $query->where(
                'course',
                $request->course
            );
        }


        if ($request->batch) {

            $query->whereHas(
                'batch',
                function ($q) use ($request) {

                    $q->where(
                        'batch_year',
                        $request->batch
                    );
                }
            );
        }


        if ($request->verification_status) {

            $query->where(
                'verification_status',
                $request->verification_status
            );
        }


        if ($request->bs_status) {

            $query->where(
                'bs_status',
                $request->bs_status
            );
        }


        if ($request->search) {

            $query->where(
                'full_name',
                'like',
                "%{$request->search}%"
            );
        }


        $cadets = $query->get();


        // =====================================================
        // TOTAL REQUIREMENTS
        // =====================================================

        $totalRequirements = Document::count();


        // =====================================================
        // CALCULATE EACH CADET
        // =====================================================

        foreach ($cadets as $cadet) {

            // -------------------------------------------------
            // VERIFICATION
            // -------------------------------------------------

            $approved = $cadet->documents
                ->where(
                    'pivot.status',
                    'Approved'
                )
                ->count();


            $cadet->required_documents_count =
                $totalRequirements;


            $cadet->approved_documents_count =
                $approved;


            if (
                $totalRequirements > 0 &&
                $approved == $totalRequirements
            ) {

                $cadet->verification_status =
                    'Verified';

            } else {

                $cadet->verification_status =
                    'Pending';
            }


            // -------------------------------------------------
            // BS REQUIREMENTS
            // -------------------------------------------------

            $totalBS =
                $cadet->bsRequirements->count();


            $completedBS =
                $cadet->bsRequirements
                    ->whereIn(
                        'status',
                        [
                            'Approved',
                            'Completed'
                        ]
                    )
                    ->count();


            $cadet->bs_required_count =
                $totalBS;


            $cadet->bs_completed_count =
                $completedBS;


            if (
                $totalBS > 0 &&
                $completedBS == $totalBS
            ) {

                $cadet->bs_status =
                    'Qualified';

            } else {

                $cadet->bs_status =
                    'Not Qualified';
            }


            // -------------------------------------------------
            // PROGRESS
            // -------------------------------------------------

            $cadet->doc_progress =
                "{$approved}/{$totalRequirements}";
        }


        // =====================================================
        // STATISTICS
        // =====================================================

        $verificationTotal =
            $cadets->count();


        $completed =
            $cadets
                ->where(
                    'verification_status',
                    'Verified'
                )
                ->count();


        $incomplete =
            $cadets
                ->where(
                    'verification_status',
                    'Pending'
                )
                ->count();


        $qualified =
            $cadets
                ->where(
                    'verification_status',
                    'Verified'
                )
                ->count();


        $notQualified =
            $cadets
                ->where(
                    'verification_status',
                    'Pending'
                )
                ->count();


        // =====================================================
        // FILTER DATA
        // =====================================================

        $courses = Cadet::select('course')
            ->distinct()
            ->orderBy('course')
            ->get();


        $batches =
            Batch::orderBy(
                'batch_year',
                'desc'
            )->get();


        return view(
            'admin.verification.index',
            compact(
                'cadets',
                'verificationTotal',
                'completed',
                'incomplete',
                'qualified',
                'notQualified',
                'courses',
                'batches'
            )
        );
    }


    // =========================================================
    // SHOW
    // =========================================================

    public function show(int $id)
    {
        $cadet = Cadet::with([
            'batch',
            'documents',
        ])->findOrFail($id);


        $documents =
            $cadet->documents;


        $totalDocs =
            $documents->count();


        $approvedDocs =
            $documents
                ->filter(function ($document) {

                    return optional(
                        $document->pivot
                    )->status === 'Approved';

                })
                ->count();


        $progress =
            $totalDocs > 0
                ? round(
                    ($approvedDocs / $totalDocs) * 100
                )
                : 0;


        return view(
            'admin.verification.show',
            compact(
                'cadet',
                'documents',
                'totalDocs',
                'approvedDocs',
                'progress'
            )
        );
    }


    // =========================================================
    // UPLOAD
    // =========================================================

    public function upload(Request $request)
    {
        $request->validate([

            'cadet_id' =>
                'required|exists:cadets,id',

            'document_id' =>
                'required|exists:documents,id',

            'status' =>
                'required',

            'file' =>
                'nullable|file|max:5120',

            'remarks' =>
                'nullable|string',
        ]);


        // =====================================================
        // GET CADET
        // =====================================================

        $cadet =
            Cadet::findOrFail(
                $request->cadet_id
            );


        // =====================================================
        // GET DOCUMENT
        // IMPORTANT: fixes your undefined $document error
        // =====================================================

        $document =
            Document::findOrFail(
                $request->document_id
            );


        // =====================================================
        // FILE
        // =====================================================

        $path = null;


        if ($request->hasFile('file')) {

            $path =
                $request
                    ->file('file')
                    ->store(
                        'documents',
                        'public'
                    );
        }


        // =====================================================
        // UPDATE PIVOT
        // =====================================================

        $cadet->documents()
            ->updateExistingPivot(
                $request->document_id,
                [

                    'file_path' =>
                        $path,

                    'status' =>
                        $request->status,

                    'submitted_at' =>
                        now(),

                ]
            );


        // =====================================================
        // RECALCULATE VERIFICATION
        // =====================================================

        $cadet->load('documents');


        $totalDocs =
            $cadet->documents->count();


        $approvedDocs =
            $cadet->documents
                ->where(
                    'pivot.status',
                    'Approved'
                )
                ->count();


        if (
            $totalDocs > 0 &&
            $approvedDocs == $totalDocs
        ) {

            $cadet->verification_status =
                'Verified';

        } else {

            $cadet->verification_status =
                'Pending';
        }


        $cadet->save();


        // =====================================================
        // SEND CADET NOTIFICATION
        // =====================================================

        if (
            in_array(
                strtolower(
                    $request->status
                ),
                [
                    'approved',
                    'rejected'
                ]
            )
        ) {

            $user = $cadet->user;


            if ($user) {

                $user->notify(

                    new VerificationRequirementStatusNotification(

                        $cadet,

                        $document,

                        $request->status,

                        $request->remarks ?? null

                    )

                );
            }
        }


        return back()
            ->with(
                'success',
                'Verification requirement updated successfully.'
            );
    }


    // =========================================================
// APPROVE ALL LEGACY DOCUMENTS
// =========================================================

public function approveLegacy(Request $request)
{
    $request->validate([
        'cadet_id' => 'required|exists:cadets,id',
    ]);

    // =====================================================
    // GET CADET
    // =====================================================

    $cadet = Cadet::findOrFail(
        $request->cadet_id
    );

    // =====================================================
    // GET ALL SYSTEM DOCUMENT REQUIREMENTS
    // =====================================================

    $documents = Document::all();

    // =====================================================
    // APPROVE EVERYTHING AS LEGACY
    // =====================================================

    DB::transaction(function () use ($cadet, $documents) {

        foreach ($documents as $document) {

            $cadet->documents()->syncWithoutDetaching([

                $document->id => [

                    'status' =>
                        'Approved',

                    'remarks' =>
                        'Approved as legacy document. No digital upload required.',

                    'submitted_at' =>
                        now(),

                ]

            ]);
        }

        // =================================================
        // MARK CADET AS VERIFIED
        // =================================================

        $cadet->verification_status =
            'Verified';

        $cadet->save();
    });

    // =====================================================
    // REDIRECT
    // =====================================================

    return redirect()
        ->route(
            'admin.verification.show',
            $cadet->id
        )
        ->with(
            'success',
            'All verification requirements have been approved as legacy documents.'
        );
}

    // =========================================================
    // UPDATE STATUS
    // =========================================================

    public function updateStatus(Request $request)
    {
        $request->validate([

            'cadet_id' =>
                'required|exists:cadets,id',

            'document_id' =>
                'required|exists:documents,id',

            'status' =>
                'required',

            'remarks' =>
                'nullable|string',
        ]);


        // =====================================================
        // GET CADET
        // =====================================================

        $cadet =
            Cadet::findOrFail(
                $request->cadet_id
            );


        // =====================================================
        // GET DOCUMENT
        // =====================================================

        $document =
            Document::findOrFail(
                $request->document_id
            );


        // =====================================================
        // UPDATE STATUS
        // =====================================================

        $cadet->documents()
            ->updateExistingPivot(
                $request->document_id,
                [

                    'status' =>
                        $request->status,

                ]
            );


        // =====================================================
        // RECALCULATE
        // =====================================================

        $cadet->load('documents');


        $totalDocs =
            $cadet->documents->count();


        $approvedDocs =
            $cadet->documents
                ->where(
                    'pivot.status',
                    'Approved'
                )
                ->count();


        if (
            $totalDocs > 0 &&
            $approvedDocs == $totalDocs
        ) {

            $cadet->verification_status =
                'Verified';

        } else {

            $cadet->verification_status =
                'Pending';
        }


        $cadet->save();


        // =====================================================
        // SEND NOTIFICATION
        // =====================================================

        if (
            in_array(
                strtolower(
                    $request->status
                ),
                [
                    'approved',
                    'rejected'
                ]
            )
        ) {

            $user =
                $cadet->user;


            if ($user) {

                $user->notify(

                    new VerificationRequirementStatusNotification(

                        $cadet,

                        $document,

                        $request->status,

                        $request->remarks ?? null

                    )

                );
            }
        }


        return back()
            ->with(
                'success',
                'Verification status updated successfully.'
            );
    }
}