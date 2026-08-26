<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Batch;
use Illuminate\Http\Request;

class CadetRequirementController extends Controller
{
    public function index()
    {
        $cadets = Cadet::with([
            'batch',
            'deployment',
            'onboardRequirements.requirement'
        ])
        ->whereHas('deployment', function ($query) {
            $query->whereIn('status', ['Ongoing', 'Completed']);
        })
        ->orderBy('full_name', 'asc')
        ->get();

        $batches = Batch::orderBy('batch_year', 'desc')->get();

        $courses = Cadet::select('course')
            ->distinct()
            ->orderBy('course')
            ->get();

        return view(
            'superadmin.cadet_requirements.index',
            compact(
                'cadets',
                'batches',
                'courses'
            )
        );
    }

    public function show($id)
    {
        $cadet = Cadet::with([
            'batch',
            'deployment',
            'onboardRequirements.requirement'
        ])->findOrFail($id);

        return response()->json([
            'id' => $cadet->id,
            'full_name' => $cadet->full_name,
            'trb_control_number' => $cadet->trb_control_number,
            'course' => $cadet->course,

            'onboard_requirements' => $cadet->onboardRequirements->map(function ($item) {

                return [
                    'id' => $item->id,
                    'status' => $item->status,

                    'submitted_at' => $item->submitted_at
                        ? $item->submitted_at->format('M d, Y h:i A')
                        : null,

                    'approved_at' => $item->approved_at
                        ? $item->approved_at->format('M d, Y h:i A')
                        : null,

                    'remarks' => $item->remarks,

                    'attachment' => $item->attachment,

                    'requirement' => [
                        'title' => optional($item->requirement)->title ?? '-',
                        'frequency' => optional($item->requirement)->frequency ?? '-',
                    ],
                ];
            })->values(),
        ]);
    }
}