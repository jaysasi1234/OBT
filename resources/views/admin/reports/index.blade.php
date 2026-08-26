@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/reports/reporting.css'])

<div class="report-page">

    <div class="main">

        <!-- HEADER -->
        <div class="header">

            <h1>
                Onboard Training Report System
            </h1>

        </div>


        <!-- REPORT BOX -->
        <div class="report-box">

            <h2>
                Reports Dashboard
            </h2>


            <!-- =================================================
                 CADET MASTERLIST
            ================================================== -->

            <div
                class="report-item"
                onclick="window.location.href='{{ route('admin.reports.cadet') }}'"
            >

                <div class="icon">
                    👥
                </div>

                <div>

                    <div class="report-title">
                        Cadet Masterlist
                    </div>

                    <small>
                        View all registered cadets and their information.
                    </small>

                </div>

            </div>


            <!-- =================================================
                 DEPLOYMENT REPORT
            ================================================== -->

            <div
                class="report-item"
                onclick="window.location.href='{{ route('admin.reports.deployment') }}'"
            >

                <div class="icon">
                    📊
                </div>

                <div>

                    <div class="report-title">
                        Deployment Percentage Report
                    </div>

                    <small>
                        Monitor deployment statistics and completion progress.
                    </small>

                </div>

            </div>


            <!-- =================================================
                 VERIFICATION REPORT
            ================================================== -->

            <div
                class="report-item"
                onclick="window.location.href='{{ route('admin.reports.verification') }}'"
            >

                <div class="icon">
                    ✔️
                </div>

                <div>

                    <div class="report-title">
                        Verification Status Report
                    </div>

                    <small>
                        Track verified, pending, and deficient cadet records.
                    </small>

                </div>

            </div>


            <!-- =================================================
                 COMPLAINT / CONCERN REPORT
            ================================================== -->

            <div
                class="report-item"
                onclick="window.location.href='{{ route('admin.reports.complaint') }}'"
            >

                <div class="icon">
                    📝
                </div>

                <div>

                    <div class="report-title">
                        Concern Summary Report
                    </div>

                    <small>
                        Review submitted concerns and their current status.
                    </small>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection