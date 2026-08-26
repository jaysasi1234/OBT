@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/remarks/remarks.css'])


<div class="main">

    {{-- =====================================================
         TOPBAR
    ====================================================== --}}
    <div class="topbar">

        <div class="topbar-title">

            <h2>Cadet Monthly Remarks</h2>

            <p>
                Manage and monitor monthly performance remarks
                for cadets.
            </p>

        </div>

        <button
            type="button"
            class="btn"
            onclick="openAddModal()">

            <span>＋</span>
            Add Remarks

        </button>

    </div>


    {{-- =====================================================
         FILTER PANEL
    ====================================================== --}}
    <div class="filter-panel">

        <div class="filter-title">
            Filter & Search
        </div>

        <div class="filter-bar">

            {{-- MONTH --}}
            <div class="filter-control">

                <select
                    id="monthFilter"
                    onchange="filterTable()">

                    <option value="">
                        All Months
                    </option>

                    <option>January</option>
                    <option>February</option>
                    <option>March</option>
                    <option>April</option>
                    <option>May</option>
                    <option>June</option>
                    <option>July</option>
                    <option>August</option>
                    <option>September</option>
                    <option>October</option>
                    <option>November</option>
                    <option>December</option>

                </select>

            </div>


            {{-- YEAR --}}
            <div class="filter-control">

                <select
                    id="yearFilter"
                    onchange="filterTable()">

                    <option value="">
                        All Years
                    </option>

                </select>

            </div>


            {{-- SEARCH --}}
            <div class="filter-control search">

                <input
                    type="text"
                    id="searchInput"
                    placeholder="Search cadet, course or batch..."
                    autocomplete="off"
                    oninput="applyFilters()">

            </div>

        </div>

    </div>


    {{-- =====================================================
         TABLE
    ====================================================== --}}
    <div class="table-box">

        <div class="table-responsive">

            <table>

                <thead>

                    <tr>

                        <th>Cadet</th>
                        <th>Course</th>
                        <th>Batch</th>
                        <th>Monthly Remarks</th>
                        <th>Action</th>

                        {{-- FILTER DATA --}}
                        <th style="display:none;">
                            Month
                        </th>

                        <th style="display:none;">
                            Year
                        </th>

                    </tr>

                </thead>


                <tbody>

                @forelse($cadets as $cadet)

                    <tr>

                        {{-- CADET --}}
                        <td>

                            <div class="cadet-info">

                                <div class="cadet-avatar">
                                    {{ strtoupper(substr($cadet->full_name, 0, 1)) }}
                                </div>

                                <div>

                                    <strong>
                                        {{ $cadet->full_name }}
                                    </strong>

                                    <small>
                                        {{ $cadet->course ?? 'No Course' }}
                                    </small>

                                </div>

                            </div>

                        </td>


                        {{-- COURSE --}}
                        <td>
                            {{ $cadet->course ?? 'No Course' }}
                        </td>


                        {{-- BATCH --}}
                        <td>
                            {{ optional($cadet->batch)->batch_year ?? 'No Batch' }}
                        </td>


                        {{-- REMARKS --}}
                        <td>

                            <textarea
                                readonly
                                aria-label="Monthly remarks for {{ $cadet->full_name }}">{{ $cadet->remarks ?? 'No remarks yet' }}</textarea>

                        </td>


                        {{-- ACTION --}}
                        <td>

                            <button
                                type="button"
                                class="action-btn"

                                data-id="{{ $cadet->id }}"
                                data-name="{{ $cadet->full_name }}"
                                data-month="{{ $cadet->remarks_month }}"
                                data-year="{{ $cadet->remarks_year }}"
                                data-remarks="{{ $cadet->remarks }}"
                                data-date="{{ $cadet->updated_at }}"

                                onclick="openEditFromButton(this)">

                                View / Edit

                            </button>

                        </td>


                        {{-- HIDDEN FILTER DATA --}}
                        <td style="display:none;">
                            {{ $cadet->remarks_month ?? '' }}
                        </td>

                        <td style="display:none;">
                            {{ $cadet->remarks_year ?? '' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            style="text-align:center;padding:40px;color:#94a3b8;">

                            No cadet records found.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- =========================================================
     VIEW / EDIT REMARK MODAL
========================================================= --}}
<div
    id="editModal"
    class="modal"
    aria-hidden="true">

    <div class="modal-content remark-modal">

        {{-- HEADER --}}
        <div class="remark-header">

            <div>

                <h2>
                    Cadet Monthly Remarks
                </h2>

                <p>
                    Edit monthly performance remarks.
                </p>

            </div>

            <button
                type="button"
                class="close-btn"
                onclick="closeModal()"
                aria-label="Close">

                ✕

            </button>

        </div>


        {{-- FORM --}}
        <form
            method="POST"
            id="editForm">

            @csrf

            {{-- CADET INFORMATION --}}
            <div class="info-grid">

                <div class="input-group">

                    <label for="cadetName">
                        Cadet Name
                    </label>

                    <input
                        type="text"
                        id="cadetName"
                        disabled>

                </div>


                <div class="input-group">

                    <label for="month">
                        Month
                    </label>

                    <select
                        name="month"
                        id="month"
                        required>

                    </select>

                </div>


                <div class="input-group">

                    <label for="year">
                        Year
                    </label>

                    <select
                        name="year"
                        id="year"
                        required>

                    </select>

                </div>


                <div class="input-group">

                    <label for="dateAdded">
                        Date Updated
                    </label>

                    <input
                        type="text"
                        id="dateAdded"
                        disabled>

                </div>

            </div>


            {{-- REMARKS --}}
            <div class="input-group remarks-box">

                <label for="remarks">
                    Monthly Remarks
                </label>

                <textarea
                    name="remarks"
                    id="remarks"
                    rows="10"
                    placeholder="Write monthly performance remarks here..."
                    required></textarea>

            </div>


            {{-- FOOTER --}}
            <div class="remark-footer">

                <button
                    type="submit"
                    class="save-btn">

                    Update Remarks

                </button>


                <button
                    type="button"
                    class="delete-btn"
                    onclick="deleteRemark()">

                    Delete

                </button>


                <button
                    type="button"
                    class="cancel-btn"
                    onclick="closeModal()">

                    Cancel

                </button>

            </div>

        </form>

    </div>

</div>


<!-- =========================
     ADD REMARK MODAL
========================= -->
<div id="addModal" class="modal">

    <div class="modal-content add-modal-content">

        <!-- HEADER -->
        <div class="add-modal-header">

            <div class="add-modal-title">
                <span class="add-modal-icon">+</span>

                <div>
                    <h2>Add Monthly Remark</h2>
                    <p>Add a performance remark for a cadet.</p>
                </div>
            </div>

            <button
                type="button"
                class="add-close"
                onclick="closeAddModal()"
                aria-label="Close modal">
                &times;
            </button>

        </div>

        <!-- FORM -->
        <form
            action="{{ route('admin.remarks.update', 0) }}"
            method="POST"
            id="addRemarkForm">

            @csrf

            <div class="add-form">

                <!-- CADET -->
                <div class="form-field full-width">

                    <label for="cadetSearch">
                        Cadet
                    </label>

                    <div class="cadet-search-wrapper">

                        <span class="search-icon">⌕</span>

                        <input
                            type="text"
                            id="cadetSearch"
                            placeholder="Search cadet by name..."
                            autocomplete="off"
                            onkeyup="filterCadetDropdown()">

                    </div>

                </div>

                <!-- CADET SELECT -->
                <div class="form-field full-width">

                    <label for="addCadet">
                        Select Cadet
                    </label>

                    <select
                        name="cadet_id"
                        id="addCadet"
                        onchange="updateAddFormAction()"
                        required>

                        <option value="">
                            Select a cadet
                        </option>

                        @foreach($cadets as $cadet)

                            <option value="{{ $cadet->id }}">
                                {{ $cadet->full_name }}
                            </option>

                        @endforeach

                    </select>

                    <small class="field-help">
                        Select the cadet whose monthly remark you want to add.
                    </small>

                </div>

                <!-- MONTH -->
                <div class="form-field">

                    <label for="addMonth">
                        Month
                    </label>

                    <select
                        name="month"
                        id="addMonth"
                        required>

                        <option value="">
                            Select month
                        </option>

                        <option>January</option>
                        <option>February</option>
                        <option>March</option>
                        <option>April</option>
                        <option>May</option>
                        <option>June</option>
                        <option>July</option>
                        <option>August</option>
                        <option>September</option>
                        <option>October</option>
                        <option>November</option>
                        <option>December</option>

                    </select>

                </div>

                <!-- YEAR -->
                <div class="form-field">

                    <label for="addYear">
                        Year
                    </label>

                    <select
                        name="year"
                        id="addYear"
                        required>

                        <option value="">
                            Select year
                        </option>

                        @for($y = date('Y'); $y <= date('Y') + 5; $y++)

                            <option value="{{ $y }}">
                                {{ $y }}
                            </option>

                        @endfor

                    </select>

                </div>

                <!-- REMARKS -->
                <div class="form-field full-width">

                    <div class="remarks-label-row">

                        <label for="addRemarks">
                            Monthly Remarks
                        </label>

                        <span class="optional-label">
                            Performance / Observation
                        </span>

                    </div>

                    <textarea
                        name="remarks"
                        id="addRemarks"
                        rows="7"
                        placeholder="Enter the cadet's monthly performance remarks..."
                        required></textarea>

                    <small class="field-help">
                        Provide clear and professional observations about the cadet's performance.
                    </small>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer add-modal-footer">

                <button
                    type="button"
                    class="cancel-btn"
                    onclick="closeAddModal()">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="save-btn">

                    <span>✓</span>
                    Add Remark

                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     JAVASCRIPT
========================================================= --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    loadYears();

});


/* =========================================================
   MODAL HELPERS
========================================================= */

function openAddModal() {

    const modal = document.getElementById('addModal');

    modal.style.display = 'flex';
    modal.setAttribute('aria-hidden', 'false');

    document.body.style.overflow = 'hidden';

}


function closeAddModal() {

    const modal = document.getElementById('addModal');

    modal.style.display = 'none';
    modal.setAttribute('aria-hidden', 'true');

    document.body.style.overflow = '';

}


function closeModal() {

    const modal = document.getElementById('editModal');

    modal.style.display = 'none';
    modal.setAttribute('aria-hidden', 'true');

    document.body.style.overflow = '';

}


/* =========================================================
   EDIT MODAL
========================================================= */

function openEditFromButton(button) {

    openEdit(
        button.dataset.id,
        button.dataset.name,
        button.dataset.month,
        button.dataset.year,
        button.dataset.remarks,
        button.dataset.date
    );

}


function openEdit(
    id,
    name,
    month,
    year,
    remarks,
    dateAdded
) {

    const modal = document.getElementById('editModal');

    modal.style.display = 'flex';
    modal.setAttribute('aria-hidden', 'false');

    document.body.style.overflow = 'hidden';


    document.getElementById('cadetName').value =
        name || '';


    document.getElementById('remarks').value =
        remarks || '';


    document.getElementById('dateAdded').value =
        formatDate(dateAdded);


    document.getElementById('editForm').action =
        "/admin/remarks/update/" + id;


    loadMonths();
    loadYearsEdit();


    document.getElementById('month').value =
        month || '';


    document.getElementById('year').value =
        year || '';

}


/* =========================================================
   DELETE REMARK
========================================================= */

function deleteRemark() {

    if (!confirm('Are you sure you want to delete this remark?')) {
        return;
    }


    const form =
        document.getElementById('editForm');


    form.action =
        form.action.replace(
            '/update/',
            '/delete/'
        );


    const existingMethod =
        form.querySelector(
            'input[name="_method"]'
        );


    if (existingMethod) {
        existingMethod.remove();
    }


    const method =
        document.createElement('input');


    method.type = 'hidden';
    method.name = '_method';
    method.value = 'DELETE';


    form.appendChild(method);

    form.submit();

}


/* =========================================================
   ADD FORM ACTION
========================================================= */

function updateAddFormAction() {

    const cadetId =
        document.getElementById('addCadet').value;


    if (!cadetId) {
        return;
    }


    document.getElementById('addRemarkForm').action =
        "/admin/remarks/update/" + cadetId;

}


/* =========================================================
   SEARCH CADET DROPDOWN
========================================================= */

function filterCadetDropdown() {

    const input =
        document.getElementById('cadetSearch')
        .value
        .toLowerCase()
        .trim();


    const select =
        document.getElementById('addCadet');


    Array.from(select.options).forEach(
        function (option, index) {

            if (index === 0) {
                return;
            }


            const text =
                option.textContent
                .toLowerCase();


            option.hidden =
                !text.includes(input);

        }
    );

}


/* =========================================================
   TABLE FILTERING
========================================================= */

function applyFilters() {

    const search =
        document.getElementById('searchInput')
        .value
        .toLowerCase()
        .trim();


    const month =
        document.getElementById('monthFilter')
        .value
        .toLowerCase()
        .trim();


    const year =
        document.getElementById('yearFilter')
        .value
        .toLowerCase()
        .trim();


    const rows =
        document.querySelectorAll(
            'table tbody tr'
        );


    rows.forEach(function (row) {

        const cells = row.children;


        if (cells.length < 7) {
            return;
        }


        const name =
            cells[0].innerText
            .toLowerCase();


        const course =
            cells[1].innerText
            .toLowerCase();


        const batch =
            cells[2].innerText
            .toLowerCase();


        const rowMonth =
            cells[5].innerText
            .toLowerCase()
            .trim();


        const rowYear =
            cells[6].innerText
            .toLowerCase()
            .trim();


        const matchesSearch =
            search === '' ||
            name.includes(search) ||
            course.includes(search) ||
            batch.includes(search);


        const matchesMonth =
            month === '' ||
            rowMonth === month;


        const matchesYear =
            year === '' ||
            rowYear === year;


        row.style.display =
            (
                matchesSearch &&
                matchesMonth &&
                matchesYear
            )
                ? ''
                : 'none';

    });

}


function searchTable() {
    applyFilters();
}


function filterTable() {
    applyFilters();
}


/* =========================================================
   LOAD YEARS
========================================================= */

function loadYears() {

    const select =
        document.getElementById('yearFilter');


    if (!select) {
        return;
    }


    const currentYear =
        new Date().getFullYear();


    const startYear = 2020;
    const endYear = currentYear + 20;


    select.innerHTML =
        '<option value="">All Years</option>';


    for (
        let year = endYear;
        year >= startYear;
        year--
    ) {

        const option =
            document.createElement('option');


        option.value = year;
        option.textContent = year;


        select.appendChild(option);

    }

}


/* =========================================================
   LOAD EDIT MONTHS
========================================================= */

function loadMonths() {

    const months = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];


    const select =
        document.getElementById('month');


    select.innerHTML =
        '<option value="">Select Month</option>';


    months.forEach(function (month) {

        const option =
            document.createElement('option');


        option.value = month;
        option.textContent = month;


        select.appendChild(option);

    });

}


/* =========================================================
   LOAD EDIT YEARS
========================================================= */

function loadYearsEdit() {

    const select =
        document.getElementById('year');


    const currentYear =
        new Date().getFullYear();


    const startYear = 2020;
    const endYear = currentYear + 20;


    select.innerHTML =
        '<option value="">Select Year</option>';


    for (
        let year = endYear;
        year >= startYear;
        year--
    ) {

        const option =
            document.createElement('option');


        option.value = year;
        option.textContent = year;


        select.appendChild(option);

    }

}


/* =========================================================
   DATE FORMAT
========================================================= */

function formatDate(dateValue) {

    if (!dateValue) {
        return 'Not available';
    }


    const date =
        new Date(dateValue);


    if (isNaN(date.getTime())) {
        return dateValue;
    }


    return date.toLocaleString(
        undefined,
        {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }
    );

}


/* =========================================================
   CLOSE MODALS WHEN CLICKING OUTSIDE
========================================================= */

window.addEventListener('click', function (event) {

    const editModal =
        document.getElementById('editModal');


    const addModal =
        document.getElementById('addModal');


    if (event.target === editModal) {
        closeModal();
    }


    if (event.target === addModal) {
        closeAddModal();
    }

});


/* =========================================================
   ESC KEY
========================================================= */

document.addEventListener('keydown', function (event) {

    if (event.key !== 'Escape') {
        return;
    }


    const editModal =
        document.getElementById('editModal');


    const addModal =
        document.getElementById('addModal');


    if (editModal.style.display === 'flex') {
        closeModal();
    }


    if (addModal.style.display === 'flex') {
        closeAddModal();
    }

});

</script>

@endsection