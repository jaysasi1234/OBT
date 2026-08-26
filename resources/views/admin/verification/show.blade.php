@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/verification/show.css'])


<div class="verification-page">

    <div class="verification-wrapper">

        <!-- =====================================================
             PAGE HEADER
        ====================================================== -->

        <div class="page-header">

            <a
                href="{{ route('admin.verification.index') }}"
                class="back-btn"
                aria-label="Back to verification">

                <span aria-hidden="true">←</span>

                <span>
                    Back to Verification
                </span>

            </a>


            <h1 class="page-title">
                Cadet Details
            </h1>


            <div aria-hidden="true"></div>

        </div>


        <!-- =====================================================
             MAIN CONTENT
        ====================================================== -->

        <div class="content-grid">


            <!-- =================================================
                 PROFILE
            ================================================== -->

            <aside class="profile-card">

                <h2 class="profile-title">
                    Cadet Information
                </h2>


                <div class="profile-avatar">

                    <img
                        src="{{ $cadet->photo
                            ? asset('storage/'.$cadet->photo)
                            : 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22300%22 height=%22300%22 viewBox=%220 0 300 300%22%3E%3Crect width=%22300%22 height=%22300%22 fill=%22172d61%22/%3E%3Ctext x=%22150%22 y=%22155%22 text-anchor=%22middle%22 fill=%22%2394a3b8%22 font-size=%2220%22 font-family=%22Arial%22%3ENo Photo%3C/text%3E%3C/svg%3E' }}"
                        alt="Cadet Photo"
                        loading="lazy"
                    >

                </div>


                <div class="profile-name">

                    {{ $cadet->full_name ?? 'Unknown Cadet' }}

                </div>


                <div class="profile-course">

                    {{ $cadet->course ?? 'Course Not Available' }}

                </div>


                <div class="profile-info">

                    <div class="info-row">

                        <span class="info-label">
                            TRB Number
                        </span>

                        <span class="info-value">
                            {{ $cadet->trb_control_number ?? 'Not Available' }}
                        </span>

                    </div>


                    <div class="info-row">

                        <span class="info-label">
                            Batch
                        </span>

                        <span class="info-value">
                            {{ optional($cadet->batch)->batch_year ?? 'Not Available' }}
                        </span>

                    </div>


                    <div class="info-row">

                        <span class="info-label">
                            Email
                        </span>

                        <span class="info-value">
                            {{ $cadet->email ?? 'Not Available' }}
                        </span>

                    </div>


                    <div class="info-row">

                        <span class="info-label">
                            Contact Number
                        </span>

                        <span class="info-value">
                            {{ $cadet->contact_number ?? 'Not Available' }}
                        </span>

                    </div>

                </div>


                <!-- =================================================
                     PROGRESS
                ================================================== -->

                @php
                    $safeTotalDocs = max(0, (int) $totalDocs);
                    $safeApprovedDocs = max(0, (int) $approvedDocs);

                    $safeProgress = $safeTotalDocs > 0
                        ? min(
                            100,
                            max(
                                0,
                                ($safeApprovedDocs / $safeTotalDocs) * 100
                            )
                        )
                        : 0;
                @endphp

                <div class="progress-section">

                    <div class="progress-header">

                        <span>
                            Verification Progress
                        </span>

                        <span class="progress-value">
                            {{ $safeApprovedDocs }}/{{ $safeTotalDocs }}
                        </span>

                    </div>


                    <div
                        class="progress-track"
                        role="progressbar"
                        aria-valuenow="{{ round($safeProgress) }}"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        aria-label="Verification progress">

                        <div
                            class="progress-fill"
                            style="width: {{ $safeProgress }}%;">
                        </div>

                    </div>

                </div>

            </aside>


            <!-- =================================================
                 REQUIREMENTS
            ================================================== -->

            <section class="requirements-card">

                <div class="requirements-header">

                    <div>

                        <h2 class="requirements-title">
                            Verification Requirements
                        </h2>

                        <div class="requirements-subtitle">
                            Review and manage submitted cadet documents
                        </div>

                    </div>

                    <div class="requirements-actions">
                        <button
                            type="button"
                            class="legacy-approve-btn"
                            onclick="approveAllLegacyDocuments()">
                            <span>✔</span>
                            Approve All Documents
                        </button>
                    </div>

                </div>


                <div class="table-scroll">

                    <table>

                        <thead>

                            <tr>

                                <th>
                                    Requirement
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    File
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                        @forelse($documents as $doc)

                            @php

                                $status = $doc->pivot->status ?? 'Pending';

                                $file = $doc->pivot->file_path ?? null;

                                $fileUrl = $file
                                    ? asset('storage/'.$file)
                                    : '';

                                $statusClass = strtolower(
                                    str_replace(
                                        ' ',
                                        '-',
                                        trim($status)
                                    )
                                );

                                $hasFile = !empty($file);

                            @endphp


                            <tr>

                                <td>

                                    {{ $doc->name ?? 'Unnamed Requirement' }}

                                </td>


                                <td>

                                    <span class="status {{ $statusClass }}">

                                        {{ $status }}

                                    </span>

                                </td>


                                <td>

                                    <div class="file-actions">

                                        <!-- VIEW -->

                                        <button
                                            type="button"
                                            class="file-btn"
                                            {{ !$hasFile ? 'disabled' : '' }}
                                            onclick="openViewModal(
                                                @js($fileUrl),
                                                @js($doc->name ?? 'Document')
                                            )">

                                            View

                                        </button>


                                        <!-- EDIT -->

                                        <button
                                            type="button"
                                            class="file-btn"
                                            onclick="openModal(
                                                {{ $doc->id }},
                                                @js($doc->name ?? 'Document'),
                                                @js($fileUrl),
                                                @js($status),
                                                @js($doc->pivot->remarks ?? '')
                                            )">

                                            Edit

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="3"
                                    style="
                                        text-align:center;
                                        padding:30px;
                                        color:#94a3b8;
                                    ">

                                    No documents found.

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </section>

        </div>

    </div>


    <form
    id="legacyApproveForm"
    method="POST"
    action="{{ route('admin.verification.approve-legacy') }}"
    style="display:none;">

    @csrf

    <input
        type="hidden"
        name="cadet_id"
        value="{{ $cadet->id }}">

</form>


    <!-- =========================================================
         EDIT MODAL
    ========================================================== -->

    <div
        id="uploadModal"
        class="modal-overlay"
        role="dialog"
        aria-modal="true"
        aria-labelledby="uploadModalTitle">

        <div class="modal-box">


            <!-- HEADER -->

            <div class="modal-header">

                <h2 id="uploadModalTitle">
                    Update Verification Status
                </h2>

                <button
                    type="button"
                    class="close-btn"
                    onclick="closeModal()"
                    aria-label="Close modal">

                    ✕

                </button>

            </div>


            <!-- BODY -->

            <div class="modal-body">


                <!-- LEFT -->

                <div class="left-section">

                    <div class="cadet-info">


                        <div class="cadet-avatar">

                            <img
                                src="{{ $cadet->photo
                                    ? asset('storage/'.$cadet->photo)
                                    : 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22300%22 height=%22300%22 viewBox=%220 0 300 300%22%3E%3Crect width=%22300%22 height=%22300%22 fill=%22172d61%22/%3E%3Ctext x=%22150%22 y=%22155%22 text-anchor=%22middle%22 fill=%22%2394a3b8%22 font-size=%2220%22 font-family=%22Arial%22%3ENo Photo%3C/text%3E%3C/svg%3E' }}"
                                alt="Cadet Photo"
                            >

                        </div>


                        <div class="cadet-details">

                            <h2>
                                {{ $cadet->full_name ?? 'Unknown Cadet' }}
                            </h2>

                            <p>
                                <strong>TRB No.:</strong>
                                {{ $cadet->trb_control_number ?? 'Not Available' }}
                            </p>

                            <hr>

                            <p>
                                <strong>Course:</strong>
                                {{ $cadet->course ?? 'Not Available' }}
                            </p>

                            <p>
                                <strong>Batch:</strong>
                                {{ optional($cadet->batch)->batch_year ?? 'Not Available' }}
                            </p>

                        </div>

                    </div>


                    <!-- REMARKS -->

                    <div class="remarks-box">

                        <label for="remarksInput">

                            Remarks

                            <span style="color:#64748b;">
                                (Optional)
                            </span>

                        </label>

                        <textarea
                            id="remarksInput"
                            name="remarks"
                            placeholder="Enter remarks for this document..."
                        ></textarea>

                    </div>

                </div>


                <!-- RIGHT -->

                <div class="right-section">

                    <div class="doc-title">

                        <small>
                            Document Type
                        </small>

                        <h3 id="documentName">
                            Document
                        </h3>

                    </div>


                    <div class="document-preview">

                        <div class="preview-header">
                            Document Preview
                        </div>


                        <div
                            class="preview-body"
                            id="editPreviewContainer">

                            <img
                                id="previewImage"
                                src=""
                                alt="Document Preview"
                                style="display:none;"
                            >

                            <div
                                id="previewPlaceholder"
                                class="preview-placeholder">

                                <div class="preview-placeholder-icon">
                                    📄
                                </div>

                                <div class="preview-placeholder-text">
                                    No document selected
                                </div>

                            </div>

                        </div>


                        <div class="preview-footer">

                            <div id="fileName">
                                No file selected
                            </div>

                            <small>
                                Document Preview
                            </small>

                        </div>

                    </div>

                </div>

            </div>


            <!-- FOOTER -->

            <div class="modal-footer">


                <div class="left-footer">

                    <button
                        type="button"
                        class="action-btn delete-btn"
                        onclick="deleteCurrentDocument()">

                        ✕ Delete

                    </button>

                </div>


                <div class="right-footer">

                    <form
                        id="uploadForm"
                        method="POST"
                        action="{{ route('admin.verification.upload') }}"
                        enctype="multipart/form-data">

                        @csrf


                        <input
                            type="hidden"
                            name="cadet_id"
                            value="{{ $cadet->id }}"
                        >


                        <input
                            type="hidden"
                            name="document_id"
                            id="document_id"
                        >


                        <input
                            type="hidden"
                            name="status"
                            id="statusInput"
                            value="Submitted"
                        >


                        <input
                            type="hidden"
                            name="remarks"
                            id="remarksFormInput"
                        >


                        <input
                            type="file"
                            id="fileInput"
                            name="file"
                            hidden
                            accept="image/*,.pdf,.doc,.docx"
                            onchange="previewFile(event)"
                        >


                        <button
                            type="button"
                            class="action-btn upload-btn"
                            onclick="document.getElementById('fileInput').click()">

                            Upload File

                        </button>


                        <button
                            type="button"
                            class="action-btn approve-btn"
                            onclick="submitStatus('Approved')">

                            ✔ Approve

                        </button>


                        <button
                            type="button"
                            class="action-btn reject-btn"
                            onclick="submitStatus('Rejected')">

                            ✖ Reject

                        </button>


                        <button
                            type="button"
                            class="action-btn cancel-btn"
                            onclick="closeModal()">

                            Cancel

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================================================
         VIEW MODAL
    ========================================================== -->

    <div
        id="viewModal"
        class="modal-overlay"
        role="dialog"
        aria-modal="true"
        aria-labelledby="viewModalTitle">

        <div class="view-modal-box">


            <!-- HEADER -->

            <div class="modal-header">

                <h2 id="viewModalTitle">
                    View Cadet Document
                </h2>

                <button
                    type="button"
                    class="close-btn"
                    onclick="closeViewModal()"
                    aria-label="Close modal">

                    ✕

                </button>

            </div>


            <!-- BODY -->

            <div class="modal-body">


                <div class="left-section">

                    <div class="cadet-info">

                        <div class="cadet-avatar">

                            <img
                                src="{{ $cadet->photo
                                    ? asset('storage/'.$cadet->photo)
                                    : 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22300%22 height=%22300%22 viewBox=%220 0 300 300%22%3E%3Crect width=%22300%22 height=%22300%22 fill=%22172d61%22/%3E%3Ctext x=%22150%22 y=%22155%22 text-anchor=%22middle%22 fill=%22%2394a3b8%22 font-size=%2220%22 font-family=%22Arial%22%3ENo Photo%3C/text%3E%3C/svg%3E' }}"
                                alt="Cadet Photo"
                            >

                        </div>


                        <div class="cadet-details">

                            <h2>
                                {{ $cadet->full_name ?? 'Unknown Cadet' }}
                            </h2>

                            <p>
                                <strong>TRB No.:</strong>
                                {{ $cadet->trb_control_number ?? 'Not Available' }}
                            </p>

                            <hr>

                            <p>
                                <strong>Course:</strong>
                                {{ $cadet->course ?? 'Not Available' }}
                            </p>

                            <p>
                                <strong>Batch:</strong>
                                {{ optional($cadet->batch)->batch_year ?? 'Not Available' }}
                            </p>

                        </div>

                    </div>


                    <div class="remarks-box">

                        <label for="viewRemarks">
                            Remarks
                        </label>

                        <textarea
                            id="viewRemarks"
                            readonly
                        >No remarks available.</textarea>

                    </div>

                </div>


                <div class="right-section">

                    <div class="doc-title">

                        <small>
                            Document Type
                        </small>

                        <h3 id="viewDocumentTitle">
                            Document
                        </h3>

                    </div>


                    <div class="document-preview">

                        <div class="preview-header">
                            Document Preview
                        </div>


                        <div
                            class="preview-body"
                            id="viewPreviewContainer">

                            <img
                                id="viewImage"
                                src=""
                                alt="Document Preview"
                                style="display:none;"
                            >

                            <iframe
                                id="viewPdf"
                                class="pdf-preview"
                                src=""
                                title="PDF Document"
                                style="display:none;"
                            ></iframe>

                            <div
                                id="viewFilePlaceholder"
                                class="file-preview-message">

                                <div class="icon">
                                    📄
                                </div>

                                <div>
                                    No document available
                                </div>

                            </div>

                        </div>


                        <div class="preview-footer">

                            <div id="viewFileName">
                                No file selected
                            </div>

                            <small>
                                Document File
                            </small>

                        </div>

                    </div>

                </div>

            </div>


            <!-- FOOTER -->

            <div class="modal-footer">

                <div></div>


                <div
                    style="
                        display:flex;
                        gap:8px;
                        flex-wrap:wrap;
                    ">

                    <a
                        id="downloadBtn"
                        href="#"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="action-btn upload-btn">

                        Open File

                    </a>


                    <button
                        type="button"
                        class="action-btn cancel-btn"
                        onclick="closeViewModal()">

                        Close

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

/* =========================================================
   GLOBAL STATE
========================================================= */

let currentDocumentId = null;
let currentDocumentUrl = '';
let currentDocumentName = '';


/* =========================================================
   ELEMENT HELPERS
========================================================= */

function getElement(id) {

    return document.getElementById(id);
}


/* =========================================================
   OPEN EDIT MODAL
========================================================= */

function openModal(
    id,
    name,
    file = '',
    status = 'Pending',
    remarks = ''
) {

    const modal = getElement('uploadModal');

    const documentId = getElement('document_id');

    const documentName = getElement('documentName');

    const fileInput = getElement('fileInput');

    const previewImage = getElement('previewImage');

    const previewPlaceholder = getElement('previewPlaceholder');

    const fileName = getElement('fileName');

    const remarksInput = getElement('remarksInput');

    const statusInput = getElement('statusInput');


    if (!modal) {
        return;
    }


    currentDocumentId = id;

    currentDocumentUrl = file || '';

    currentDocumentName = name || 'Document';


    modal.style.display = 'flex';


    if (documentId) {
        documentId.value = id || '';
    }


    if (documentName) {
        documentName.innerText =
            currentDocumentName;
    }


    if (fileInput) {
        fileInput.value = '';
    }


    if (remarksInput) {

        remarksInput.value =
            remarks || '';
    }


    if (statusInput) {

        statusInput.value =
            status || 'Submitted';
    }


    if (file) {

        showEditPreview(file);

        if (fileName) {

            fileName.innerText =
                getFileName(file);
        }

    } else {

        showEditPlaceholder();

        if (fileName) {

            fileName.innerText =
                'No file selected';
        }
    }


    document.body.style.overflow = 'hidden';
}


/* =========================================================
   CLOSE EDIT MODAL
========================================================= */

function closeModal() {

    const modal =
        getElement('uploadModal');

    if (!modal) {
        return;
    }

    modal.style.display = 'none';

    document.body.style.overflow = '';

    currentDocumentId = null;

    currentDocumentUrl = '';

    currentDocumentName = '';
}


/* =========================================================
   SHOW EDIT PREVIEW
========================================================= */

function showEditPreview(file) {

    const previewImage =
        getElement('previewImage');

    const placeholder =
        getElement('previewPlaceholder');

    if (!previewImage || !placeholder) {
        return;
    }


    const extension =
        getFileExtension(file);


    if (isImageFile(extension)) {

        previewImage.src = file;

        previewImage.style.display = 'block';

        placeholder.style.display = 'none';

    } else {

        previewImage.style.display = 'none';

        placeholder.style.display = 'flex';

        placeholder.innerHTML = `
            <div class="preview-placeholder-icon">
                ${extension === 'pdf' ? '📕' : '📄'}
            </div>

            <div class="preview-placeholder-text">
                ${extension === 'pdf'
                    ? 'PDF document'
                    : 'Document file'}
            </div>
        `;
    }
}


/* =========================================================
   SHOW EDIT PLACEHOLDER
========================================================= */

function showEditPlaceholder() {

    const previewImage =
        getElement('previewImage');

    const placeholder =
        getElement('previewPlaceholder');

    if (previewImage) {

        previewImage.style.display =
            'none';

        previewImage.removeAttribute('src');
    }

    if (placeholder) {

        placeholder.style.display =
            'flex';

        placeholder.innerHTML = `
            <div class="preview-placeholder-icon">
                📄
            </div>

            <div class="preview-placeholder-text">
                No document selected
            </div>
        `;
    }
}


/* =========================================================
   FILE PREVIEW
========================================================= */

function previewFile(event) {

    const file =
        event.target.files &&
        event.target.files[0];

    if (!file) {
        return;
    }


    const fileName =
        getElement('fileName');

    if (fileName) {

        fileName.innerText =
            file.name;
    }


    const preview =
        getElement('previewImage');

    const placeholder =
        getElement('previewPlaceholder');


    if (!preview || !placeholder) {
        return;
    }


    if (file.type.startsWith('image/')) {

        const objectUrl =
            URL.createObjectURL(file);

        preview.src =
            objectUrl;

        preview.style.display =
            'block';

        placeholder.style.display =
            'none';

        return;
    }


    preview.style.display =
        'none';

    placeholder.style.display =
        'flex';


    if (
        file.type === 'application/pdf' ||
        file.name.toLowerCase().endsWith('.pdf')
    ) {

        placeholder.innerHTML = `
            <div class="preview-placeholder-icon">
                📕
            </div>

            <div class="preview-placeholder-text">
                PDF document selected
            </div>
        `;

    } else {

        placeholder.innerHTML = `
            <div class="preview-placeholder-icon">
                📄
            </div>

            <div class="preview-placeholder-text">
                ${escapeHtml(file.name)}
            </div>
        `;
    }
}


/* =========================================================
   SUBMIT STATUS
========================================================= */

function submitStatus(status) {

    const form =
        getElement('uploadForm');

    const statusInput =
        getElement('statusInput');

    const remarksInput =
        getElement('remarksInput');

    const remarksFormInput =
        getElement('remarksFormInput');


    if (!form || !statusInput) {
        return;
    }


    statusInput.value =
        status;


    if (
        remarksInput &&
        remarksFormInput
    ) {

        remarksFormInput.value =
            remarksInput.value.trim();
    }


    /*
     * Confirmation for rejection.
     */

    if (status === 'Rejected') {

        const confirmed =
            confirm(
                'Are you sure you want to reject this document?'
            );

        if (!confirmed) {
            return;
        }
    }


    form.submit();
}


/* =========================================================
   DELETE CURRENT DOCUMENT
========================================================= */

function deleteCurrentDocument() {

    if (!currentDocumentId) {

        alert(
            'Please select a document first.'
        );

        return;
    }


    const confirmed =
        confirm(
            'Are you sure you want to delete this document file?'
        );


    if (!confirmed) {
        return;
    }


    /*
     * IMPORTANT:
     *
     * Replace the route below if your actual
     * delete route has a different name.
     *
     * This creates a normal POST request using
     * the existing Laravel CSRF token.
     */

    const form =
        document.createElement('form');

    form.method = 'POST';

    form.action =
        "{{ route('admin.verification.upload') }}";


    const csrf =
        document.createElement('input');

    csrf.type = 'hidden';

    csrf.name = '_token';

    csrf.value =
        "{{ csrf_token() }}";


    const method =
        document.createElement('input');

    method.type = 'hidden';

    method.name = '_method';

    method.value = 'DELETE';


    const cadetId =
        document.createElement('input');

    cadetId.type = 'hidden';

    cadetId.name = 'cadet_id';

    cadetId.value =
        "{{ $cadet->id }}";


    const documentId =
        document.createElement('input');

    documentId.type = 'hidden';

    documentId.name = 'document_id';

    documentId.value =
        currentDocumentId;


    form.appendChild(csrf);

    form.appendChild(method);

    form.appendChild(cadetId);

    form.appendChild(documentId);

    document.body.appendChild(form);

    form.submit();
}


/* =========================================================
   VIEW MODAL
========================================================= */

function openViewModal(
    file,
    name,
    remarks = ''
) {

    const modal =
        getElement('viewModal');

    const title =
        getElement('viewDocumentTitle');

    const download =
        getElement('downloadBtn');

    const fileName =
        getElement('viewFileName');

    const viewRemarks =
        getElement('viewRemarks');


    if (!modal) {
        return;
    }


    modal.style.display =
        'flex';


    if (title) {

        title.innerText =
            name || 'Document';
    }


    if (viewRemarks) {

        viewRemarks.value =
            remarks || 'No remarks available.';
    }


    if (file) {

        showViewPreview(file);

        if (download) {

            download.href =
                file;

            download.style.display =
                'inline-flex';
        }

        if (fileName) {

            fileName.innerText =
                getFileName(file);
        }

    } else {

        showViewPlaceholder();

        if (download) {

            download.href =
                '#';

            download.style.display =
                'none';
        }

        if (fileName) {

            fileName.innerText =
                'No document available';
        }
    }


    document.body.style.overflow =
        'hidden';
}


/* =========================================================
   CLOSE VIEW MODAL
========================================================= */

function closeViewModal() {

    const modal =
        getElement('viewModal');

    if (!modal) {
        return;
    }


    modal.style.display =
        'none';


    document.body.style.overflow =
        '';


    const image =
        getElement('viewImage');

    const pdf =
        getElement('viewPdf');


    if (image) {

        image.style.display =
            'none';

        image.removeAttribute('src');
    }


    if (pdf) {

        pdf.style.display =
            'none';

        pdf.src =
            '';
    }
}


/* =========================================================
   SHOW VIEW PREVIEW
========================================================= */

function showViewPreview(file) {

    const image =
        getElement('viewImage');

    const pdf =
        getElement('viewPdf');

    const placeholder =
        getElement('viewFilePlaceholder');


    if (!image || !pdf || !placeholder) {
        return;
    }


    image.style.display =
        'none';

    pdf.style.display =
        'none';

    placeholder.style.display =
        'none';


    const extension =
        getFileExtension(file);


    if (isImageFile(extension)) {

        image.src =
            file;

        image.style.display =
            'block';

        return;
    }


    if (extension === 'pdf') {

        pdf.src =
            file;

        pdf.style.display =
            'block';

        return;
    }


    placeholder.innerHTML = `
        <div class="icon">
            📄
        </div>

        <div>
            Preview is not available for this file type.
        </div>
    `;

    placeholder.style.display =
        'flex';
}


/* =========================================================
   SHOW VIEW PLACEHOLDER
========================================================= */

function showViewPlaceholder() {

    const image =
        getElement('viewImage');

    const pdf =
        getElement('viewPdf');

    const placeholder =
        getElement('viewFilePlaceholder');


    if (image) {

        image.style.display =
            'none';

        image.removeAttribute('src');
    }


    if (pdf) {

        pdf.style.display =
            'none';

        pdf.src =
            '';
    }


    if (placeholder) {

        placeholder.innerHTML = `
            <div class="icon">
                📄
            </div>

            <div>
                No document available
            </div>
        `;

        placeholder.style.display =
            'flex';
    }
}


/* =========================================================
   FILE HELPERS
========================================================= */

function getFileName(file) {

    if (!file) {
        return '';
    }

    try {

        return decodeURIComponent(
            file.split('/').pop().split('?')[0]
        );

    } catch (error) {

        return file.split('/').pop();
    }
}


function getFileExtension(file) {

    if (!file) {
        return '';
    }

    const cleanFile =
        file.split('?')[0];

    const parts =
        cleanFile.split('.');

    if (parts.length < 2) {
        return '';
    }

    return parts
        .pop()
        .toLowerCase();
}


function isImageFile(extension) {

    return [
        'jpg',
        'jpeg',
        'png',
        'gif',
        'webp',
        'bmp',
        'svg'
    ].includes(extension);
}


/* =========================================================
   ESCAPE HTML
========================================================= */

function escapeHtml(value) {

    const div =
        document.createElement('div');

    div.textContent =
        value ?? '';

    return div.innerHTML;
}


/* =========================================================
   CLOSE WHEN CLICKING OUTSIDE
========================================================= */

document.addEventListener(
    'click',
    function(event) {

        const uploadModal =
            getElement('uploadModal');

        const viewModal =
            getElement('viewModal');


        if (
            uploadModal &&
            event.target === uploadModal
        ) {

            closeModal();
        }


        if (
            viewModal &&
            event.target === viewModal
        ) {

            closeViewModal();
        }

    }
);


/* =========================================================
   ESC KEY
========================================================= */

document.addEventListener(
    'keydown',
    function(event) {

        if (event.key !== 'Escape') {
            return;
        }


        const uploadModal =
            getElement('uploadModal');

        const viewModal =
            getElement('viewModal');


        if (
            uploadModal &&
            uploadModal.style.display === 'flex'
        ) {

            closeModal();

            return;
        }


        if (
            viewModal &&
            viewModal.style.display === 'flex'
        ) {

            closeViewModal();
        }

    }
);


/* =========================================================
   PREVENT MODAL FORM SUBMISSION BY ENTER
========================================================= */

document.addEventListener(
    'keydown',
    function(event) {

        if (
            event.key === 'Enter' &&
            event.target.tagName === 'TEXTAREA'
        ) {

            return;
        }

    }
);

/* =========================================================
   APPROVE ALL LEGACY DOCUMENTS
========================================================= */

function approveAllLegacyDocuments() {

    const form =
        document.getElementById(
            'legacyApproveForm'
        );

    if (!form) {

        console.error(
            'Legacy approval form was not found.'
        );

        return;
    }

    const confirmed =
        confirm(
            'Approve ALL verification documents for this cadet as legacy documents?\n\n' +
            'No document uploads will be required.\n\n' +
            'This should only be used for old/legacy cadets whose documents were completed before this system was implemented.'
        );

    if (!confirmed) {
        return;
    }

    form.submit();
}
</script>

@endsection