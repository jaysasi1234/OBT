@extends('layouts.superadmin')

@section('content')

<style>

/* FILTER */
.filter-bar {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.filter-bar select,
.filter-bar input {
    padding: 10px;
    border-radius: 8px;
    border: none;
    background: #1a1a4a;
    color: white;
    outline: none;
}

/* TABLE */
.table-box {
    background: #1a1a4a;
    padding: 15px;
    border-radius: 12px;
}

table {
    width: 100%;
    border-collapse: collapse;
    color: white;
}

th {
    background: #2a2a6a;
    padding: 12px;
    text-align: left;
}

td {
    padding: 12px;
    border-bottom: 1px solid #333;
}

/* TEXTAREA */
textarea {
    width: 100%;
    background: #0f0f2f;
    color: white;
    border: none;
    border-radius: 6px;
    padding: 8px;
}

/* BUTTON */
.btn {
    background: #3b82f6;
    color: white;
    border: none;
    padding: 10px 14px;
    border-radius: 8px;
    cursor: pointer;
}

/* ACTION BUTTON */
.action-btn {
    background: #3b82f6;
    border: none;
    padding: 6px 10px;
    color: white;
    border-radius: 6px;
    cursor: pointer;
}

/* MODAL */
.modal {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.7);
    z-index: 999;
}

.modal-content {
    background: #14143a;
    width: 520px;
    margin: 80px auto;
    padding: 20px;
    border-radius: 12px;
    color: white;
}

.modal-content input,
.modal-content select,
.modal-content textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 8px;
    border: none;
    background: #1a1a4a;
    color: white;
}

.modal-buttons {
    display: flex;
    gap: 10px;
}

/* FILTER WRAPPER */
.filter-group {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
}

/* MODERN SELECT BOX */
.custom-select {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.custom-select label {
    font-size: 12px;
    color: #b8b8ff;
    margin-left: 2px;
}

/* SELECT DESIGN */
.custom-select select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;

    background: linear-gradient(145deg, #1a1a4a, #151542);
    color: white;

    padding: 10px 35px 10px 12px;
    border-radius: 10px;
    border: 1px solid #2f2f6d;

    cursor: pointer;
    outline: none;

    transition: 0.2s ease;
}

/* hover + focus effect */
.custom-select select:hover,
.custom-select select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 2px rgba(99,102,241,0.2);
}

/* dropdown arrow */
.custom-select {
    position: relative;
}

.custom-select::after {
    content: "▼";
    font-size: 10px;
    position: absolute;
    right: 12px;
    top: 34px;
    color: #aaa;
    pointer-events: none;
}

/* ==========================
   RESPONSIVE VIEW MODAL
========================== */

.modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.75);
    z-index:9999;

    justify-content:center;
    align-items:center;

    padding:15px;
}

.modal-content{
    width:100%;
    max-width:700px;

    background:#14143a;
    border-radius:16px;

    padding:25px;

    max-height:90vh;
    overflow-y:auto;
}

.modal-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.close-btn{
    background:none;
    border:none;
    color:white;
    font-size:30px;
    cursor:pointer;
}

.view-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
}

.view-group{
    margin-bottom:15px;
}

.view-group label{
    display:block;
    margin-bottom:6px;
    font-size:13px;
    color:#cbd5e1;
}

.view-group input,
.view-group textarea{
    width:100%;
    background:#1a1a4a;
    color:white;
    border:none;
    border-radius:10px;
    padding:12px;
}

.view-group textarea{
    resize:none;
}

.modal-footer{
    text-align:right;
    margin-top:15px;
}

.close-modal-btn{
    background:#f59e0b;
    color:white;
    border:none;
    border-radius:10px;
    padding:10px 20px;
    cursor:pointer;
}

/* MOBILE */

@media(max-width:768px){

    .filter-bar{
        flex-direction:column;
    }

    .view-row{
        grid-template-columns:1fr;
    }

    .table-box{
        overflow-x:auto;
    }

    table{
        min-width:800px;
    }

    .modal-content{
        padding:18px;
    }

}
</style>

    <!-- TOP -->
    <div class="topbar">
    <h2>Cadet Monthly Remarks</h2>
    </div>

    <!-- FILTER -->
<div class="filter-bar">

    <select id="monthFilter" onchange="filterTable()">
        <option value="">All Month</option>
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

    <select id="yearFilter" onchange="filterTable()">
        <option value="">All Year</option>
    </select>

    <input type="text" id="searchInput" placeholder="Search Cadet..." onkeyup="searchTable()">

</div>

    <!-- TABLE -->
    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Course</th>
                    <th>Batch</th>
                    <th>Remarks</th>
                    <th>Action</th>
                    <th style="display:none;">Month</th>
                    <th style="display:none;">Year</th>
                </tr>
            </thead>

            <tbody>
            @foreach($cadets as $cadet)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cadet->full_name ?? '-' }}</td>
                    <td>{{ $cadet->course }}</td>
                    <td>{{ optional($cadet->batch)->batch_year ?? 'No Batch' }}</td>

                    <td>
                        <textarea readonly>{{ $cadet->remarks ?? 'No remarks yet' }}</textarea>
                    </td>

                    <td>
                        <button class="action-btn"
                            data-id="{{ $cadet->id }}"
                            data-name="{{ $cadet->full_name }}"
                            data-month="{{ $cadet->remarks_month }}"
                            data-year="{{ $cadet->remarks_year }}"
                            data-remarks="{{ $cadet->remarks }}"
                            data-date="{{ $cadet->updated_at }}"
                            onclick="openEditFromButton(this)">
                            View
                        </button>
                    </td>
                    <td style="display:none;">{{ $cadet->remarks_month ?? '' }}</td>
                    <td style="display:none;">{{ $cadet->remarks_year ?? '' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- VIEW MODAL -->
<div id="editModal" class="modal">

    <div class="modal-content">

        <div class="modal-header">
            <h3>Cadet Remarks Details</h3>

            <button class="close-btn"
                    onclick="closeModal()">
                ×
            </button>
        </div>

        <div class="view-group">
            <label>Cadet Name</label>
            <input type="text" id="cadetName" readonly>
        </div>

        <div class="view-row">

            <div class="view-group">
                <label>Month</label>
                <input type="text" id="month" readonly>
            </div>

            <div class="view-group">
                <label>Year</label>
                <input type="text" id="year" readonly>
            </div>

        </div>

        <div class="view-group">
            <label>Remarks</label>

            <textarea id="remarks"
                      rows="8"
                      readonly></textarea>
        </div>

        <div class="view-group">
            <label>Last Updated</label>
            <input type="text" id="dateAdded" readonly>
        </div>

        <div class="modal-footer">
            <button type="button"
                    class="close-modal-btn"
                    onclick="closeModal()">
                Close
            </button>
        </div>

    </div>

</div>

<script>

/* SEARCH */
function searchTable() {

    let filter = document.getElementById("searchInput").value.toLowerCase();

    let rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {

        let name = row.children[1].innerText.toLowerCase();
        let course = row.children[2].innerText.toLowerCase();
        let batch = row.children[3].innerText.toLowerCase();

        let match =
            name.includes(filter) ||
            course.includes(filter) ||
            batch.includes(filter);

        row.style.display = match ? "" : "none";
    });
}
</script>

<script>

function openEditFromButton(btn)
{
    document.getElementById('editModal').style.display = 'flex';

    document.getElementById('cadetName').value =
        btn.dataset.name || '';

    document.getElementById('month').value =
        btn.dataset.month || '';

    document.getElementById('year').value =
        btn.dataset.year || '';

    document.getElementById('remarks').value =
        btn.dataset.remarks || 'No remarks available';

    document.getElementById('dateAdded').value =
        btn.dataset.date || '';
}

function closeModal()
{
    document.getElementById('editModal').style.display = 'none';
}

window.addEventListener('click', function(e){

    const modal =
        document.getElementById('editModal');

    if(e.target === modal)
    {
        closeModal();
    }

});

function filterTable() {

    let month = document.getElementById("monthFilter").value.toLowerCase().trim();
    let year = document.getElementById("yearFilter").value.toLowerCase().trim();

    let rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {

        // IMPORTANT: correct hidden columns
        let rowMonth = row.children[6].innerText.toLowerCase().trim();
        let rowYear  = row.children[7].innerText.toLowerCase().trim();

        let matchMonth = month === "" || rowMonth === month;
        let matchYear = year === "" || rowYear === year;

        row.style.display = (matchMonth && matchYear) ? "" : "none";
    });
}

function loadYears() {
    const yearSelect = document.getElementById("yearFilter");

    const currentYear = new Date().getFullYear();
    const startYear = 2020;
    const endYear = currentYear + 20;

    let options = `<option value="">All Year</option>`;

    for (let y = endYear; y >= startYear; y--) {
        options += `<option value="${y}">${y}</option>`;
    }

    yearSelect.innerHTML = options;
}

loadYears();

function loadMonths() {
    const months = [
        "January","February","March","April","May","June",
        "July","August","September","October","November","December"
    ];

    let monthSelect = document.getElementById("month");

    monthSelect.innerHTML = `<option value="">Select Month</option>`;

    months.forEach(m => {
        monthSelect.innerHTML += `<option value="${m}">${m}</option>`;
    });
}

function loadYearsEdit() {
    const yearSelect = document.getElementById("year");

    const currentYear = new Date().getFullYear();
    const startYear = 2020;
    const endYear = currentYear + 20;

    let options = `<option value="">Select Year</option>`;

    for (let y = endYear; y >= startYear; y--) {
        options += `<option value="${y}">${y}</option>`;
    }

    yearSelect.innerHTML = options;
}

function openEdit(id, name, month, year, remarks, dateAdded) {
    document.getElementById('editModal').style.display = 'block';

    document.getElementById('cadetName').value = name;
    document.getElementById('remarks').value = remarks || '';
    document.getElementById('dateAdded').innerText = dateAdded;

    document.getElementById('editForm').action = "/admin/remarks/update/" + id;

    // LOAD DROPDOWNS
    loadMonths();
    loadYearsEdit();

    // SET VALUES AFTER LOAD
    setTimeout(() => {
        document.getElementById('month').value = month;
        document.getElementById('year').value = year;
    }, 50);
}

</script>

@endsection