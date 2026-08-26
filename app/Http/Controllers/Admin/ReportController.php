<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Batch;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /* =========================
       MAIN REPORT
    ========================= */

    public function index(Request $request)
    {
        $query = Cadet::with(['batch','complaints','deployment','shippedOnOrder']);

        $courses = Cadet::select('course')->distinct()->get();
        $batches = Batch::all();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name','like',"%{$request->search}%")
                  ->orWhere('course','like',"%{$request->search}%")
                  ->orWhere('id','like',"%{$request->search}%");
            });
        }

        if ($request->course) {
            $query->where('course',$request->course);
        }

        if ($request->batch) {
            $query->where('batch_id',$request->batch);
        }

        if ($request->deployment_status) {
            $this->applyDeploymentFilter(
                $query,
                $request->deployment_status
            );
        }

        if ($request->verification_status) {
            $query->where(
                'verification_status',
                $request->verification_status
            );
        }

        $cadets = $query->latest()->get();

        foreach ($cadets as $cadet) {
            $deployment = $cadet->deployment;

            $cadet->deployment_percentage =
                $deployment?->percentage ??
                match ($deployment?->status) {
                    'Completed' => 100,
                    'Ongoing'   => 50,
                    default     => 0
                };

            $cadet->bs_status =
                $cadet->complaints->count()
                    ? 'With Issue'
                    : ($cadet->verification_status === 'Verified'
                        ? 'Good'
                        : 'Pending');
        }

        return view('admin.reports.index',compact(
            'cadets','batches','courses'
        ));
    }


    /* =========================
       CADET MASTERLIST
    ========================= */

    public function cadetMasterlist(Request $request)
    {
        $query = Cadet::with([
            'batch',
            'deployment',
            'complaints',
            'shippedOnOrder'
        ]);

        $courses = Cadet::select('course')
            ->distinct()
            ->orderBy('course')
            ->get();

        $batches = Batch::orderBy('batch_year','desc')->get();

        if ($request->search) {
            $query->where(
                'full_name',
                'like',
                "%{$request->search}%"
            );
        }

        if ($request->course) {
            $query->where('course',$request->course);
        }

        if ($request->batch) {
            $query->where('batch_id',$request->batch);
        }

        if ($request->deployment_status) {
            $this->applyDeploymentFilter(
                $query,
                $request->deployment_status
            );
        }

        if ($request->verification_status) {
            $query->where(
                'verification_status',
                $request->verification_status
            );
        }

        $cadets = $query->latest()->get();

        return view(
            'admin.reports.cadet-masterlist',
            compact('cadets','batches','courses')
        );
    }


    /* =========================
       DEPLOYMENT REPORT
    ========================= */

    public function deployment(Request $request)
    {
        $cadets = $this->deploymentQuery($request)->get();

        $data = $this->buildDeploymentData($cadets);

        return view(
            'admin.reports.deployment',
            $data
        );
    }


    /* =========================
       VERIFICATION REPORT
    ========================= */

    public function verification(Request $request)
    {
        $query = Cadet::with('batch');

        $courses = Cadet::select('course')
            ->distinct()
            ->orderBy('course')
            ->get();

        if ($request->course) {
            $query->where('course',$request->course);
        }

        if ($request->batch) {
            $query->where('batch_id',$request->batch);
        }

        if ($request->status) {
            $query->where(
                'verification_status',
                $request->status
            );
        }

        if ($request->search) {
            $query->where(
                'full_name',
                'like',
                "%{$request->search}%"
            );
        }

        $cadets = $query->latest()->get();

        foreach ($cadets as $cadet) {
            $cadet->verification_label =
                in_array($cadet->verification_status,[
                    'Verified',
                    'Pending',
                    'Deficiency'
                ])
                ? $cadet->verification_status
                : 'Not Submitted';
        }

        return view('admin.reports.verification',[
            'cadets'     => $cadets,
            'courses'    => $courses,
            'batches'    => Batch::all(),
            'verified'   => $cadets->where(
                'verification_status','Verified'
            )->count(),
            'pending'    => $cadets->where(
                'verification_status','Pending'
            )->count(),
            'deficiency' => $cadets->where(
                'verification_status','Deficiency'
            )->count()
        ]);
    }


    /* =========================
       COMPLAINT REPORT
    ========================= */

    public function complaint(Request $request)
    {
        $query = Complaint::with(['cadet.batch']);

        $courses = Cadet::select('course')->distinct()->get();
        $batches = Batch::all();

        if ($request->course && $request->course !== 'All') {
            $query->whereHas('cadet',fn($q) =>
                $q->where('course',$request->course)
            );
        }

        if ($request->batch) {
            $query->whereHas('cadet',fn($q) =>
                $q->where('batch_id',$request->batch)
            );
        }

        if ($request->status && $request->status !== 'All') {
            $query->where('status',$request->status);
        }

        if ($request->search) {
            $query->whereHas('cadet',fn($q) =>
                $q->where(
                    'full_name',
                    'like',
                    "%{$request->search}%"
                )
            );
        }

        $complaints = $query->latest()->get();

        return view(
            'admin.reports.complaint',
            compact('complaints','courses','batches')
        );
    }


    /* =========================
       VERIFICATION PDF
    ========================= */

    public function verificationPdf(Request $request)
    {
        $query = Cadet::with('batch');

        if ($request->filled('course')) {
            $query->where('course',$request->course);
        }

        if ($request->filled('batch')) {
            $query->where('batch_id',$request->batch);
        }

        if ($request->filled('status')) {
            $query->where(
                'verification_status',
                $request->status
            );
        }

        if ($request->filled('search')) {
            $query->where(
                'full_name',
                'like',
                "%{$request->search}%"
            );
        }

        $cadets = $query->get();

        return Pdf::loadView(
            'admin.reports.pdf.verification_pdf',
            compact('cadets')
        )
        ->setPaper('letter','portrait')
        ->download('Verification_Report.pdf');
    }


    /* =========================
       COMPLAINT PDF
    ========================= */

    public function complaintPdf(Request $request)
    {
        $query = Complaint::with(['cadet.batch']);

        if ($request->filled('course')) {
            $query->whereHas(
                'cadet',
                fn($q) => $q->where('course',$request->course)
            );
        }

        if ($request->filled('batch')) {
            $query->whereHas(
                'cadet',
                fn($q) => $q->where('batch_id',$request->batch)
            );
        }

        if ($request->filled('status')) {
            $query->where('status',$request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas(
                'cadet',
                fn($q) => $q->where(
                    'full_name',
                    'like',
                    "%{$request->search}%"
                )
            );
        }

        $complaints = $query->latest()->get();

        return Pdf::loadView(
            'admin.reports.pdf.complaint_pdf',
            compact('complaints')
        )
        ->setPaper('letter','portrait')
        ->download('Complaint_Report.pdf');
    }


    /* =========================
       CADET MASTERLIST PDF
    ========================= */

    public function cadetMasterlistPdf(Request $request)
    {
        $query = Cadet::with([
            'batch',
            'deployment',
            'complaints',
            'documents'
        ])->withCount('complaints');

        if ($request->filled('search')) {
            $query->where(
                'full_name',
                'like',
                "%{$request->search}%"
            );
        }

        if ($request->filled('course')) {
            $query->where('course',$request->course);
        }

        if ($request->filled('batch')) {
            $query->where('batch_id',$request->batch);
        }

        if ($request->filled('deployment_status')) {
            $this->applyDeploymentFilter(
                $query,
                $request->deployment_status
            );
        }

        if ($request->filled('verification_status')) {
            $query->where(
                'verification_status',
                $request->verification_status
            );
        }

        $cadets = $query->get();

        return Pdf::loadView(
            'admin.reports.pdf.cadet_masterlist_pdf',
            compact('cadets')
        )
        ->setPaper('letter','portrait')
        ->download('Cadet_Masterlist_Report.pdf');
    }


/* =========================
   DEPLOYMENT PDF
========================= */

public function deploymentPdf(Request $request)
{
    $cadets = $this->deploymentQuery($request)->get();

    $data = $this->buildDeploymentData($cadets);

    // Build the summary required by deployment_pdf.blade.php
    $data['summary'] = $this->buildDeploymentSummary($cadets);

    $pdf = Pdf::loadView(
        'admin.reports.pdf.deployment_pdf',
        $data
    )->setPaper('A4', 'landscape');

    return $pdf->download('Deployment_Report.pdf');
}


/* =========================
   BUILD DEPLOYMENT SUMMARY
========================= */

private function buildDeploymentSummary($cadets)
{
    return $cadets
        ->groupBy(function ($cadet) {
            return $cadet->batch?->batch_year ?? 'N/A';
        })
        ->map(function ($group, $ay) {

            /*
            |--------------------------------------------------------------------------
            | COURSE GROUPS
            |--------------------------------------------------------------------------
            */

            $bsmt = $group->filter(function ($cadet) {
                return strtoupper(trim($cadet->course ?? '')) === 'BSMT';
            });

            $bsmare = $group->filter(function ($cadet) {
                return strtoupper(trim($cadet->course ?? '')) === 'BSMARE';
            });


            /*
            |--------------------------------------------------------------------------
            | BSMT DEPLOYMENT
            |--------------------------------------------------------------------------
            */

            $bsmtDomestic = $bsmt->filter(function ($cadet) {
                return $cadet->deployment?->deployment_type === 'Domestic';
            })->count();

            $bsmtInternational = $bsmt->filter(function ($cadet) {
                return $cadet->deployment?->deployment_type === 'International';
            })->count();

            $bsmtTotal = $bsmtDomestic + $bsmtInternational;


            /*
            |--------------------------------------------------------------------------
            | BSMARE DEPLOYMENT
            |--------------------------------------------------------------------------
            */

            $bsmareDomestic = $bsmare->filter(function ($cadet) {
                return $cadet->deployment?->deployment_type === 'Domestic';
            })->count();

            $bsmareInternational = $bsmare->filter(function ($cadet) {
                return $cadet->deployment?->deployment_type === 'International';
            })->count();

            $bsmareTotal = $bsmareDomestic + $bsmareInternational;


            /*
            |--------------------------------------------------------------------------
            | DEPLOYMENT PERCENTAGE
            |--------------------------------------------------------------------------
            */

            $bsmtPercentage = $bsmt->count()
                ? round(($bsmtTotal / $bsmt->count()) * 100, 1)
                : 0;

            $bsmarePercentage = $bsmare->count()
                ? round(($bsmareTotal / $bsmare->count()) * 100, 1)
                : 0;


            /*
            |--------------------------------------------------------------------------
            | ON-BOARD
            |--------------------------------------------------------------------------
            */

            $onboardBsmt = $bsmt->filter(function ($cadet) {
                return $cadet->deployment?->status === 'Ongoing';
            })->count();

            $onboardBsmare = $bsmare->filter(function ($cadet) {
                return $cadet->deployment?->status === 'Ongoing';
            })->count();


            /*
            |--------------------------------------------------------------------------
            | DISEMBARKED
            |--------------------------------------------------------------------------
            */

            $disembarkedBsmt = $bsmt->filter(function ($cadet) {
                return $cadet->deployment?->status === 'Completed';
            })->count();

            $disembarkedBsmare = $bsmare->filter(function ($cadet) {
                return $cadet->deployment?->status === 'Completed';
            })->count();


            /*
            |--------------------------------------------------------------------------
            | SHIPPED ON ORDER STATUS
            |--------------------------------------------------------------------------
            |
            | Actual database statuses:
            |
            | For Deliberation
            | For Endorsement
            | Shipped
            |
            | Report labels:
            |
            | FOR DELIBERATION
            | ENDORSED FOR S.O.
            | WITH S.O.
            |
            */


            /*
            |--------------------------------------------------------------------------
            | FOR DELIBERATION
            |--------------------------------------------------------------------------
            */

            $deliberationBsmt = $bsmt->filter(function ($cadet) {

                return $cadet->shippedOnOrder?->status === 'For Deliberation';

            })->count();


            $deliberationBsmare = $bsmare->filter(function ($cadet) {

                return $cadet->shippedOnOrder?->status === 'For Deliberation';

            })->count();


            /*
            |--------------------------------------------------------------------------
            | ENDORSED FOR S.O.
            |--------------------------------------------------------------------------
            |
            | Database:
            | For Endorsement
            |
            */

            $endorsedBsmt = $bsmt->filter(function ($cadet) {

                return $cadet->shippedOnOrder?->status === 'For Endorsement';

            })->count();


            $endorsedBsmare = $bsmare->filter(function ($cadet) {

                return $cadet->shippedOnOrder?->status === 'For Endorsement';

            })->count();


            /*
            |--------------------------------------------------------------------------
            | WITH S.O.
            |--------------------------------------------------------------------------
            |
            | Database:
            | Shipped
            |
            */

            $soBsmt = $bsmt->filter(function ($cadet) {

                return $cadet->shippedOnOrder
                    && !empty(trim((string) $cadet->shippedOnOrder->so_number));

            })->count();


            $soBsmare = $bsmare->filter(function ($cadet) {

                return $cadet->shippedOnOrder
                    && !empty(trim((string) $cadet->shippedOnOrder->so_number));

            })->count();

            /*
            |--------------------------------------------------------------------------
            | CCI / AOU
            |--------------------------------------------------------------------------
            |
            | These remain zero because no CCI/AOU field has been identified
            | in the supplied Cadet model structure.
            |
            */

            $bsmtCci = 0;
            $bsmtAou = 0;

            $bsmareCci = 0;
            $bsmareAou = 0;


            /*
            |--------------------------------------------------------------------------
            | RETURN SUMMARY
            |--------------------------------------------------------------------------
            */

            return [

                'ay' => $ay,

                /*
                |--------------------------------------------------------------------------
                | BSMT / BSMARE CCI & AOU
                |--------------------------------------------------------------------------
                */

                'bsmt_cci' => $bsmtCci,
                'bsmt_aou' => $bsmtAou,

                'bsmare_cci' => $bsmareCci,
                'bsmare_aou' => $bsmareAou,


                /*
                |--------------------------------------------------------------------------
                | DEPLOYMENT
                |--------------------------------------------------------------------------
                */

                'bsmt_domestic' => $bsmtDomestic,
                'bsmt_international' => $bsmtInternational,
                'bsmt_total' => $bsmtTotal,

                'bsmare_domestic' => $bsmareDomestic,
                'bsmare_international' => $bsmareInternational,
                'bsmare_total' => $bsmareTotal,


                /*
                |--------------------------------------------------------------------------
                | DEPLOYMENT %
                |--------------------------------------------------------------------------
                */

                'bsmt_percentage' => $bsmtPercentage,
                'bsmare_percentage' => $bsmarePercentage,


                /*
                |--------------------------------------------------------------------------
                | ON-BOARD
                |--------------------------------------------------------------------------
                */

                'onboard_bsmt' => $onboardBsmt,
                'onboard_bsmare' => $onboardBsmare,


                /*
                |--------------------------------------------------------------------------
                | DISEMBARKED
                |--------------------------------------------------------------------------
                */

                'disembarked_bsmt' => $disembarkedBsmt,
                'disembarked_bsmare' => $disembarkedBsmare,


                /*
                |--------------------------------------------------------------------------
                | FOR DELIBERATION
                |--------------------------------------------------------------------------
                */

                'deliberation_bsmt' => $deliberationBsmt,
                'deliberation_bsmare' => $deliberationBsmare,


                /*
                |--------------------------------------------------------------------------
                | ENDORSED FOR S.O.
                |--------------------------------------------------------------------------
                */

                'endorsed_bsmt' => $endorsedBsmt,
                'endorsed_bsmare' => $endorsedBsmare,


                /*
                |--------------------------------------------------------------------------
                | WITH S.O.
                |--------------------------------------------------------------------------
                */

                'so_bsmt' => $soBsmt,
                'so_bsmare' => $soBsmare,
            ];
        })
        ->sortBy(function ($row) {
            return is_numeric($row['ay'])
                ? (int) $row['ay']
                : PHP_INT_MAX;
        })
        ->values();
}

    /* =========================
       DEPLOYMENT QUERY
    ========================= */

    private function deploymentQuery(Request $request)
    {
        $query = Cadet::with([
            'batch',
            'deployment',
            'shippedOnOrder'
        ]);

        if ($request->filled('course') &&
            $request->course !== 'All') {
            $query->where('course',$request->course);
        }

        if ($request->filled('batch')) {
            $query->where('batch_id',$request->batch);
        }

        if ($request->filled('search')) {
            $query->where(
                'full_name',
                'like',
                "%{$request->search}%"
            );
        }

        if ($request->filled('status')) {
            $this->applyDeploymentFilter(
                $query,
                $request->status
            );
        }

        return $query;
    }


    /* =========================
       DEPLOYMENT FILTER
    ========================= */

    private function applyDeploymentFilter($query,$status)
    {
        if ($status === 'Not Deployed') {

            $query->where(function($q) {
                $q->whereDoesntHave('deployment')
                  ->orWhereHas(
                      'deployment',
                      fn($d) => $d->where(
                          'status',
                          'Not Deployed'
                      )
                  );
            });

        } else {

            $query->whereHas(
                'deployment',
                fn($q) => $q->where('status',$status)
            );

        }

        return $query;
    }


    /* =========================
       BUILD DEPLOYMENT DATA
    ========================= */

    private function buildDeploymentData($cadets)
    {
        $totalBatches = $cadets
            ->whereNotNull('batch_id')
            ->pluck('batch_id')
            ->unique()
            ->count();

        $grandTotal = $grandCompleted =
        $grandOngoing = $grandNot =
        $grandDomestic = $grandInternational = 0;

        $grouped = $cadets
            ->groupBy(fn($c) => $c->course.'-'.$c->batch_id)
            ->map(function($group) use (
                &$grandTotal,
                &$grandCompleted,
                &$grandOngoing,
                &$grandNot,
                &$grandDomestic,
                &$grandInternational
            ) {

                $total = $group->count();

                $completed = $group->filter(
                    fn($c) => $c->deployment?->status === 'Completed'
                )->count();

                $ongoing = $group->filter(
                    fn($c) => $c->deployment?->status === 'Ongoing'
                )->count();

                $not = $group->filter(
                    fn($c) =>
                        !$c->deployment ||
                        $c->deployment?->status === 'Not Deployed'
                )->count();

                $domestic = $group->filter(
                    fn($c) =>
                        $c->deployment?->deployment_type === 'Domestic'
                )->count();

                $international = $group->filter(
                    fn($c) =>
                        $c->deployment?->deployment_type === 'International'
                )->count();

                $grandTotal += $total;
                $grandCompleted += $completed;
                $grandOngoing += $ongoing;
                $grandNot += $not;
                $grandDomestic += $domestic;
                $grandInternational += $international;

                return [
                    'course' => $group->first()->course,
                    'batch_year' =>
                        $group->first()->batch?->batch_year ?? 'N/A',
                    'cadets' => $group,
                    'total' => $total,
                    'completed' => $completed,
                    'ongoing' => $ongoing,
                    'not' => $not,
                    'domestic' => $domestic,
                    'international' => $international,
                    'completed_percentage' =>
                        $total ? round($completed/$total*100,1) : 0,
                    'ongoing_percentage' =>
                        $total ? round($ongoing/$total*100,1) : 0,
                    'not_percentage' =>
                        $total ? round($not/$total*100,1) : 0
                ];
            });

        return [
            'grouped' => $grouped,
            'courses' => Cadet::select('course')
                ->distinct()
                ->orderBy('course')
                ->get(),
            'batches' => Batch::orderBy(
                'batch_year',
                'desc'
            )->get(),
            'grandTotal' => $grandTotal,
            'grandCompleted' => $grandCompleted,
            'grandOngoing' => $grandOngoing,
            'grandNot' => $grandNot,
            'grandDomestic' => $grandDomestic,
            'grandInternational' => $grandInternational,
            'totalBatches' => $totalBatches
        ];
    }


    /* =========================
       CSV EXPORT
    ========================= */

    public function export(Request $request)
    {
        $query = Cadet::with('batch');

        if ($request->search) {
            $query->where(
                'full_name',
                'like',
                "%{$request->search}%"
            );
        }

        if ($request->course) {
            $query->where('course',$request->course);
        }

        if ($request->batch) {
            $query->where('batch_id',$request->batch);
        }

        if ($request->deployment_status) {
            $this->applyDeploymentFilter(
                $query,
                $request->deployment_status
            );
        }

        if ($request->verification_status) {
            $query->where(
                'verification_status',
                $request->verification_status
            );
        }

        $cadets = $query->get();

        $filename =
            'cadet_report_'.date('Ymd_His').'.csv';

        $handle = fopen($filename,'w+');

        fputcsv($handle,[
            'ID',
            'Name',
            'Course',
            'Batch',
            'Training Status',
            'Deployment %',
            'BS Status',
            'Complaints'
        ]);

        foreach ($cadets as $c) {
            fputcsv($handle,[
                $c->id,
                $c->full_name,
                $c->course,
                $c->batch?->batch_year,
                $c->training_status,
                $c->deployment_percentage ?? '0%',
                $c->bs_status ?? 'N/A',
                $c->complaints->count() ? 'Yes' : 'No'
            ]);
        }

        fclose($handle);

        return response()
            ->download($filename)
            ->deleteFileAfterSend(true);
    }
}