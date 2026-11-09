
@extends('layouts.cadet')

@section('content')

<style>
    .obt-policy-page {
        padding: 28px;
        color: #fff;
        max-width: 1500px;
        margin: auto;
    }

    .obt-policy-heading {
        margin-bottom: 25px;
    }

    .obt-policy-heading h1 {
        font-size: 27px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .obt-policy-heading p {
        color: #94a3b8;
        font-size: 14px;
        line-height: 1.7;
    }

    .obt-policy-hero {
        background: linear-gradient(120deg, #12366b, #10254a);
        border: 1px solid rgba(96,165,250,.2);
        border-radius: 18px;
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
    }

    .obt-policy-hero-icon {
        width: 65px;
        height: 65px;
        min-width: 65px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(96,165,250,.16);
        color: #93c5fd;
        font-size: 28px;
    }

    .obt-policy-hero h2 {
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .obt-policy-hero p {
        color: #cbd5e1;
        font-size: 13px;
        line-height: 1.7;
        margin: 0;
    }

    .obt-policy-card {
        background: #0f1e38;
        border: 1px solid rgba(148,163,184,.13);
        border-radius: 17px;
        padding: 24px;
        margin-bottom: 22px;
    }

    .obt-policy-card h3 {
        font-size: 17px;
        font-weight: 750;
        margin-bottom: 18px;
    }

    .obt-policy-meta {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 13px;
        margin-bottom: 20px;
    }

    .obt-policy-meta-item {
        background: #142746;
        border: 1px solid rgba(148,163,184,.1);
        padding: 14px;
        border-radius: 11px;
    }

    .obt-policy-meta-item span {
        display: block;
        color: #94a3b8;
        font-size: 11px;
        margin-bottom: 6px;
    }

    .obt-policy-meta-item strong {
        font-size: 13px;
        color: #e2e8f0;
    }

    .obt-policy-reader-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        padding: 14px 16px;
        background: #142746;
        border: 1px solid rgba(148,163,184,.13);
        border-bottom: none;
        border-radius: 12px 12px 0 0;
    }

    .obt-policy-reader-title {
        font-size: 13px;
        font-weight: 700;
        color: #e2e8f0;
    }

    .obt-policy-reader-title span {
        display: block;
        color: #94a3b8;
        font-size: 11px;
        font-weight: 400;
        margin-top: 4px;
    }

    .obt-policy-actions {
        display: flex;
        align-items: center;
        gap: 9px;
        flex-wrap: wrap;
    }

    .obt-policy-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 14px;
        background: #2563eb;
        color: #fff;
        border: 1px solid #2563eb;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        transition: .2s;
        cursor: pointer;
    }

    .obt-policy-btn:hover {
        background: #1d4ed8;
        color: #fff;
        transform: translateY(-1px);
    }

    .obt-policy-btn.secondary {
        background: #1e3558;
        border-color: rgba(148,163,184,.2);
        color: #cbd5e1;
    }

    .obt-policy-btn.secondary:hover {
        background: #29466f;
        color: #fff;
    }

    .obt-policy-viewer {
        position: relative;
        background: #26364d;
        border: 1px solid rgba(148,163,184,.13);
        border-radius: 0 0 12px 12px;
        overflow: hidden;
    }

    .obt-policy-viewer iframe {
        display: block;
        width: 100%;
        height: 780px;
        border: none;
        background: #fff;
    }

    .obt-policy-reader-note {
        color: #94a3b8;
        font-size: 11px;
        line-height: 1.7;
        padding: 12px 15px;
        background: #142746;
        border-top: 1px solid rgba(148,163,184,.1);
    }

    .obt-policy-missing {
        padding: 17px;
        border-radius: 11px;
        background: rgba(239,68,68,.10);
        border: 1px solid rgba(239,68,68,.25);
        color: #fca5a5;
        font-size: 13px;
        line-height: 1.7;
    }

    .obt-policy-alert {
        padding: 15px;
        border-radius: 11px;
        background: rgba(59,130,246,.10);
        border: 1px solid rgba(59,130,246,.22);
        color: #bfdbfe;
        font-size: 13px;
        line-height: 1.7;
        margin-bottom: 18px;
    }

    .obt-policy-success {
        padding: 15px;
        border-radius: 11px;
        background: rgba(34,197,94,.10);
        border: 1px solid rgba(34,197,94,.25);
        color: #86efac;
        font-size: 13px;
        line-height: 1.7;
    }

    .obt-policy-ack {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 18px;
        background: #142746;
        border: 1px solid rgba(148,163,184,.12);
        border-radius: 13px;
    }

    .obt-policy-ack input {
        width: 18px;
        height: 18px;
        min-width: 18px;
        margin-top: 3px;
        accent-color: #3b82f6;
    }

    .obt-policy-ack label {
        color: #cbd5e1;
        font-size: 13px;
        line-height: 1.7;
        cursor: pointer;
    }

    .obt-policy-submit {
        margin-top: 18px;
        padding: 12px 19px;
        border: none;
        border-radius: 9px;
        background: #2563eb;
        color: white;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .obt-policy-submit:hover {
        background: #1d4ed8;
    }

    .obt-policy-submit:disabled {
        opacity: .5;
        cursor: not-allowed;
    }

    @media(max-width: 800px) {
        .obt-policy-page {
            padding: 18px;
        }

        .obt-policy-meta {
            grid-template-columns: 1fr;
        }

        .obt-policy-viewer iframe {
            height: 650px;
        }
    }

    @media(max-width: 600px) {
        .obt-policy-hero {
            align-items: flex-start;
            flex-direction: column;
        }

        .obt-policy-reader-toolbar {
            align-items: flex-start;
            flex-direction: column;
        }

        .obt-policy-actions {
            width: 100%;
        }

        .obt-policy-actions a {
            flex: 1;
        }

        .obt-policy-viewer iframe {
            height: 550px;
        }

        .obt-policy-card {
            padding: 17px;
        }
    }
</style>

<div class="obt-policy-page">

    {{-- PAGE HEADING --}}
    <div class="obt-policy-heading">
        <h1>OBT Policies</h1>

        <p>
            Official Onboard Training Manual and guidelines of
            Merchant Marine Academy of Caraga, Inc.
        </p>
    </div>

    {{-- HERO --}}
    <div class="obt-policy-hero">

        <div class="obt-policy-hero-icon">
            <i class="fas fa-book-open"></i>
        </div>

        <div>
            <h2>Onboard Training Manual</h2>

            <p>
                Read the official Onboard Training Manual to understand
                the requirements, procedures, assessments, and
                responsibilities related to your Onboard Training.
            </p>
        </div>

    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="obt-policy-success" style="margin-bottom:20px;">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- MANUAL INFORMATION --}}
    <div class="obt-policy-card">

        <h3>
            <i class="fas fa-file-alt"></i>
            Official Manual Information
        </h3>

        <div class="obt-policy-meta">

            <div class="obt-policy-meta-item">
                <span>Institution</span>
                <strong>MMACI</strong>
            </div>

            <div class="obt-policy-meta-item">
                <span>Manual Revision</span>
                <strong>Revision 03</strong>
            </div>

            <div class="obt-policy-meta-item">
                <span>Effectivity Date</span>
                <strong>December 16, 2024</strong>
            </div>

        </div>

        @if($manualAvailable)

            <div class="obt-policy-actions">

                <a href="{{ route('cadet.obt-policies.download') }}"
                   class="obt-policy-btn">

                    <i class="fas fa-file-word"></i>
                    Download Original DOCX

                </a>

                @if($pdfAvailable)

                    <a href="{{ route('cadet.obt-policies.download-pdf') }}"
                       class="obt-policy-btn secondary">

                        <i class="fas fa-file-pdf"></i>
                        Download PDF

                    </a>

                @endif

            </div>

        @else

            <div class="obt-policy-missing">
                <i class="fas fa-exclamation-circle"></i>
                The original official OBT Manual has not been uploaded.
                Please contact the OBT Office.
            </div>

        @endif

    </div>

    {{-- EMBEDDED PDF READER --}}
    <div class="obt-policy-card">

        <h3>
            <i class="fas fa-book-reader"></i>
            Read Official OBT Manual
        </h3>

        @if($pdfAvailable)

            <div class="obt-policy-reader-toolbar">

                <div class="obt-policy-reader-title">

                    <i class="fas fa-file-pdf"
                       style="color:#f87171;margin-right:6px;"></i>

                    MMACI Official Onboard Training Manual

                    <span>
                        Revision 03 · PDF Document
                    </span>

                </div>

                <div class="obt-policy-actions">

                    <a href="{{ route('cadet.obt-policies.preview') }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="obt-policy-btn secondary">

                        <i class="fas fa-expand"></i>
                        Open Full Screen

                    </a>

                    <a href="{{ route('cadet.obt-policies.download-pdf') }}"
                       class="obt-policy-btn">

                        <i class="fas fa-download"></i>
                        Download PDF

                    </a>

                </div>

            </div>

            <div class="obt-policy-viewer">

                <iframe
                    src="{{ route('cadet.obt-policies.preview') }}"
                    title="Official MMACI OBT Manual PDF Reader"
                    loading="lazy">

                </iframe>

                <div class="obt-policy-reader-note">

                    <i class="fas fa-info-circle"></i>

                    Use the PDF viewer toolbar to navigate pages,
                    zoom in or out, and print the official manual.
                    If your browser does not support embedded PDF
                    viewing, use the Open Full Screen button.

                </div>

            </div>

        @else

            <div class="obt-policy-missing">

                <i class="fas fa-exclamation-circle"></i>

                The PDF reading copy has not yet been uploaded.

                <br>

                Please contact the OBT Office or system administrator.

            </div>

        @endif

    </div>

    {{-- ACKNOWLEDGEMENT --}}
    <div class="obt-policy-card">

        <h3>
            <i class="fas fa-user-check"></i>
            Policy Acknowledgement
        </h3>

        @if($acknowledgement)

            <div class="obt-policy-success">

                <i class="fas fa-check-circle"></i>

                You have acknowledged the current OBT Manual.

                <br>

                <strong>
                    Acknowledged:

                    {{ \Carbon\Carbon::parse(
                        $acknowledgement->acknowledged_at
                    )->format('F d, Y h:i A') }}
                </strong>

            </div>

        @elseif($manualAvailable)

            <div class="obt-policy-alert">

                Please read the official OBT Manual using the
                document reader above before confirming your
                acknowledgement.

            </div>

            <form
                method="POST"
                action="{{ route('cadet.obt-policies.acknowledge') }}"
                id="obtPolicyAckForm">

                @csrf

                <div class="obt-policy-ack">

                    <input
                        type="checkbox"
                        id="obtPolicyConfirm"
                        required>

                    <label for="obtPolicyConfirm">

                        I confirm that I have read and understood
                        the official Onboard Training Manual of
                        Merchant Marine Academy of Caraga, Inc.
                        and acknowledge that I am responsible
                        for following its applicable guidelines
                        and requirements.

                    </label>

                </div>

                <button
                    type="submit"
                    class="obt-policy-submit"
                    id="obtPolicySubmit"
                    disabled>

                    <i class="fas fa-check"></i>
                    Acknowledge OBT Manual

                </button>

            </form>

        @else

            <div class="obt-policy-alert">

                Acknowledgement will be available after the
                original official manual has been uploaded.

            </div>

        @endif

    </div>

</div>

{{-- ACKNOWLEDGEMENT CHECKBOX --}}
@if($manualAvailable && !$acknowledgement)

<script>
document.addEventListener('DOMContentLoaded', function () {

    const checkbox = document.getElementById('obtPolicyConfirm');
    const button = document.getElementById('obtPolicySubmit');

    if (checkbox && button) {

        checkbox.addEventListener('change', function () {

            button.disabled = !this.checked;

        });

    }

});
</script>

@endif

@endsection