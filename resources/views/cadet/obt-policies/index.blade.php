
@extends('layouts.cadet')

@section('content')

<style>
    .obt-policy-page {
        padding: 28px;
        color: #fff;
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
        padding: 28px;
        display: flex;
        align-items: center;
        gap: 22px;
        margin-bottom: 24px;
    }

    .obt-policy-hero-icon {
        width: 70px;
        height: 70px;
        min-width: 70px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(96,165,250,.16);
        color: #93c5fd;
        font-size: 30px;
    }

    .obt-policy-hero h2 {
        font-size: 21px;
        font-weight: 800;
        margin-bottom: 8px;
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

    .obt-policy-document {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 18px;
        background: #142746;
        border: 1px solid rgba(148,163,184,.12);
        border-radius: 13px;
    }

    .obt-policy-file-icon {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(239,68,68,.12);
        color: #f87171;
        font-size: 23px;
    }

    .obt-policy-document-info {
        flex: 1;
        min-width: 0;
    }

    .obt-policy-document-info strong {
        display: block;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .obt-policy-document-info span {
        color: #94a3b8;
        font-size: 12px;
    }

    .obt-policy-download {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 16px;
        background: #2563eb;
        color: #fff;
        border-radius: 9px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
        transition: .2s;
    }

    .obt-policy-download:hover {
        background: #1d4ed8;
        color: white;
        transform: translateY(-2px);
    }

    .obt-policy-sections {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 13px;
    }

    .obt-policy-section {
        padding: 16px;
        background: #142746;
        border: 1px solid rgba(148,163,184,.10);
        border-radius: 12px;
    }

    .obt-policy-section strong {
        display: block;
        font-size: 13px;
        margin-bottom: 6px;
    }

    .obt-policy-section span {
        color: #94a3b8;
        font-size: 12px;
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

    .obt-policy-success {
        padding: 15px;
        border-radius: 11px;
        background: rgba(34,197,94,.10);
        border: 1px solid rgba(34,197,94,.25);
        color: #86efac;
        font-size: 13px;
        line-height: 1.7;
    }

    .obt-policy-missing {
        padding: 16px;
        border-radius: 11px;
        background: rgba(239,68,68,.10);
        border: 1px solid rgba(239,68,68,.25);
        color: #fca5a5;
        font-size: 13px;
        line-height: 1.7;
    }

    @media(max-width: 700px) {
        .obt-policy-page {
            padding: 18px;
        }

        .obt-policy-hero {
            align-items: flex-start;
            flex-direction: column;
        }

        .obt-policy-sections {
            grid-template-columns: 1fr;
        }

        .obt-policy-document {
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .obt-policy-download {
            width: 100%;
        }
    }
</style>

<div class="obt-policy-page">

    <div class="obt-policy-heading">
        <h1>OBT Policies</h1>
        <p>
            Official Onboard Training Manual and guidelines of
            Merchant Marine Academy of Caraga, Inc.
        </p>
    </div>

    <div class="obt-policy-hero">

        <div class="obt-policy-hero-icon">
            <i class="fas fa-book-open"></i>
        </div>

        <div>
            <h2>Onboard Training Manual</h2>

            <p>
                Read and understand the official guidelines,
                requirements, and procedures governing your
                Onboard Training.
            </p>
        </div>

    </div>

    @if(session('success'))
        <div class="obt-policy-success" style="margin-bottom:20px;">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="obt-policy-card">

        <h3>
            <i class="fas fa-file-alt"></i>
            Official OBT Manual
        </h3>

        @if($manualAvailable)

            <div class="obt-policy-document">

                <div class="obt-policy-file-icon">
                    <i class="fas fa-file-word"></i>
                </div>

                <div class="obt-policy-document-info">

                    <strong>
                        MMACI Official Onboard Training Manual
                    </strong>

                    <span>
                        Revision 03 · Word Document · Official Manual
                    </span>

                </div>

                <a href="{{ route('cadet.obt-policies.download') }}"
                   class="obt-policy-download">

                    <i class="fas fa-download"></i>
                    Download Manual

                </a>

            </div>

        @else

            <div class="obt-policy-missing">
                <i class="fas fa-exclamation-circle"></i>

                The official OBT Manual has not yet been uploaded
                to the system. Please contact the OBT Office.
            </div>

        @endif

    </div>

    <div class="obt-policy-card">

        <h3>
            <i class="fas fa-list-alt"></i>
            Manual Contents
        </h3>

        <div class="obt-policy-sections">

            <div class="obt-policy-section">
                <strong>Section 1 – Objectives of OBT</strong>
                <span>OBT objectives and training guidelines</span>
            </div>

            <div class="obt-policy-section">
                <strong>Section 2 – OBT Requirements</strong>
                <span>Requirements for BSMT and BSMarE programs</span>
            </div>

            <div class="obt-policy-section">
                <strong>Section 3 – General Requirements</strong>
                <span>General requirements for the OBT program</span>
            </div>

            <div class="obt-policy-section">
                <strong>Section 4 – Records of OBT</strong>
                <span>Training records and documentation</span>
            </div>

            <div class="obt-policy-section">
                <strong>Section 5 – Validation of OBT</strong>
                <span>Validation of completed onboard training</span>
            </div>

            <div class="obt-policy-section">
                <strong>Section 6 – Assessment</strong>
                <span>Assessment procedures</span>
            </div>

            <div class="obt-policy-section">
                <strong>Section 7 – Remediation</strong>
                <span>Remediation procedures</span>
            </div>

            <div class="obt-policy-section">
                <strong>Section 8 – Sanction</strong>
                <span>Sanctions under the OBT Manual</span>
            </div>

        </div>

        <p style="color:#94a3b8;font-size:12px;margin-top:16px;">
            These are the section headings from the official manual.
            Refer to the original document for the complete provisions.
        </p>

    </div>

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
                    {{ \Carbon\Carbon::parse($acknowledgement->acknowledged_at)->format('F d, Y h:i A') }}
                </strong>
            </div>

        @elseif($manualAvailable)

            <div class="obt-policy-alert">
                Please download and read the official OBT Manual
                before confirming your acknowledgement.
            </div>

            <form method="POST"
                  action="{{ route('cadet.obt-policies.acknowledge') }}"
                  id="obtPolicyAckForm">

                @csrf

                <div class="obt-policy-ack">

                    <input type="checkbox"
                           id="obtPolicyConfirm"
                           required>

                    <label for="obtPolicyConfirm">
                        I confirm that I have read and understood the
                        official Onboard Training Manual of Merchant
                        Marine Academy of Caraga, Inc. and acknowledge
                        that I am responsible for following its
                        applicable guidelines and requirements.
                    </label>

                </div>

                <button type="submit"
                        class="obt-policy-submit"
                        id="obtPolicySubmit"
                        disabled>

                    <i class="fas fa-check"></i>
                    Acknowledge OBT Manual

                </button>

            </form>

        @else

            <div class="obt-policy-alert">
                Acknowledgement will be available after the official
                manual has been uploaded.
            </div>

        @endif

    </div>

</div>

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