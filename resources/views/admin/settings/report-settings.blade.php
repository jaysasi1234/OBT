@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/settings/report-settings.css'])


<div class="main">

    <div class="settings-container">

        <a href="{{ route('admin.settings.index') }}"
            class="close-page-btn"
            title="Back to Settings">
            ✕
        </a>

        <div class="settings-title">
            Settings
        </div>

        <div class="top-bar">

            <div>
                <h2>Manage Report Settings</h2>
                <p>Configure report types and display settings.</p>
            </div>

                <button class="add-btn" onclick="openModal()">
                    + Add New Report
                </button>

        </div>

        <div class="table-box">

            <table class="report-table">
                <thead>
                    <tr>
                        <th>Report Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->report_name }}</td>
                        <td>{{ $report->description }}</td>
                        <td>
                            <span class="status">
                                {{ $report->status }}
                            </span>
                        </td>
                        <td>
                            <button class="action-btn"
                                onclick="editReport(
                                '{{ $report->id }}',
                                '{{ $report->report_name }}',
                                '{{ $report->description }}'
                                )">
                                Edit
                            </button>

                            <form action="{{ route('admin.report.settings.delete', $report->id) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button class="delete-btn">
                                    🗑
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

<form action="{{ route('admin.report.settings.save') }}" method="POST">

            <div class="bottom-grid">

                <div class="card">
                    <div class="card-header">
                        Report Display Settings
                    </div>

                    <div class="card-body">

                        <div class="setting-row">
                            <span>Include System Logo</span>
                            <input type="checkbox"
                                   class="switch"
                                   name="include_logo"
                                   checked>
                        </div>

                        <div class="setting-row">
                            <span>Include Date Generated</span>
                            <input type="checkbox"
                                   class="switch"
                                   name="include_date"
                                   checked>
                        </div>

                        <div class="setting-row">
                            <span>Report Format</span>
                        </div>

                        <select name="report_format" class="input-box">
                            <option value="PDF">PDF</option>
                            <option value="Excel">Excel</option>
                        </select>

                        <div class="setting-row">
                            <span>Default Report Title</span>
                        </div>

                        <input type="text"
                               name="default_title"
                               class="input-box"
                               value="Cadet Information Report">
                    </div>
                </div>

                <div>

                    <div class="card">
                        <div class="card-header">
                            Report Export Option
                        </div>

                        <div class="card-body">

                            <div class="setting-row">
                                <span>Allow Export to PDF</span>
                                <input type="checkbox"
                                       class="switch"
                                       name="export_pdf"
                                       checked>
                            </div>

                            <div class="setting-row">
                                <span>Allow Export to Excel</span>
                                <input type="checkbox"
                                       class="switch"
                                       name="export_excel"
                                       checked>
                            </div>

                            <div class="setting-row">
                                <span>Allow Print Report</span>
                                <input type="checkbox"
                                       class="switch"
                                       name="allow_print"
                                       checked>
                            </div>

                        </div>
                    </div>

                    <button class="save-btn">
                        Save Settings
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<!-- ADD / EDIT MODAL -->
<div class="modal" id="reportModal">

    <div class="modal-content">

        <div class="modal-header">
            <h2 id="modalTitle">Add New Report</h2>
            <span style="cursor:pointer; font-size:22px;"
                  onclick="closeModal()">
                  ×
            </span>
        </div>

        <form id="reportForm" method="POST"
              action="{{ route('admin.report.settings.store') }}">
            @csrf

            <div class="modal-body">

                <label>Report Name:</label>
                <input type="text"
                       name="report_name"
                       id="report_name"
                       placeholder="Enter report name"
                       required>

                <label>Description:</label>
                <textarea name="description"
                          id="description"
                          rows="5"
                          placeholder="Enter description"
                          required></textarea>

                <div class="modal-footer">
                    <button type="button"
                            class="cancel-btn"
                            onclick="closeModal()">
                            Cancel
                    </button>

                    <button type="submit"
                            class="submit-btn">
                            Save Report
                    </button>
                </div>

            </div>

        </form>

    </div>

</div>

<script>

function openModal(){
    document.getElementById('reportModal').style.display = 'flex';
}

function closeModal(){
    document.getElementById('reportModal').style.display = 'none';
}

function editReport(id, name, description){

    openModal();

    document.getElementById('modalTitle').innerHTML = 'Edit Report';

    document.getElementById('report_name').value = name;
    document.getElementById('description').value = description;

    let form = document.getElementById('reportForm');

    form.action = '/report-settings/update/' + id;

    if(!document.getElementById('putMethod')){
        let method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'PUT';
        method.id = 'putMethod';

        form.appendChild(method);
    }
}

window.onclick = function(event){
    let modal = document.getElementById('reportModal');

    if(event.target == modal){
        closeModal();
    }
}

</script>

@endsection