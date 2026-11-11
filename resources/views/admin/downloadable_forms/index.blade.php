@extends('layouts.admin')

@section('header-title', 'Downloadable Forms')

@section('content')

<style>
    .forms-page {
        padding: 25px;
        color: #eaf0ff;
        min-height: 80vh;
    }

    .forms-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .forms-header h2 {
        color: #fff;
        font-size: 25px;
        font-weight: 800;
        margin: 0 0 6px;
    }

    .forms-header p {
        color: #9eafd0;
        margin: 0;
    }

    .forms-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 17px;
        border-radius: 10px;
        background: linear-gradient(135deg, #3867e8, #2448ad);
        color: white;
        text-decoration: none;
        border: none;
        font-weight: 700;
        cursor: pointer;
    }

    .forms-btn:hover {
        color: white;
        filter: brightness(1.12);
    }

    .forms-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 25px;
    }

    .forms-stat {
        background: #111d3c;
        border: 1px solid #26375e;
        border-radius: 15px;
        padding: 20px;
    }

    .forms-stat small {
        color: #9eafd0;
        display: block;
        margin-bottom: 8px;
    }

    .forms-stat strong {
        color: #fff;
        font-size: 27px;
    }

    .forms-panel {
        background: #101c39;
        border: 1px solid #26375e;
        border-radius: 15px;
        overflow: hidden;
    }

    .forms-panel-heading {
        padding: 18px 20px;
        border-bottom: 1px solid #26375e;
        font-size: 17px;
        font-weight: 800;
        color: #fff;
    }

    .forms-table-wrap {
        overflow-x: auto;
    }

    .forms-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    .forms-table th {
        background: #192b52;
        color: #cbd8f5;
        padding: 14px;
        text-align: left;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .forms-table td {
        padding: 15px 14px;
        border-top: 1px solid #26375e;
        color: #e4ebff;
        vertical-align: middle;
    }

    .forms-table tr:hover td {
        background: #152547;
    }

    .forms-muted {
        color: #9eafd0;
        font-size: 12px;
    }

    .forms-status {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
    }

    .forms-status.published {
        color: #86efac;
        background: rgba(22, 163, 74, .15);
    }

    .forms-status.draft {
        color: #fcd34d;
        background: rgba(217, 119, 6, .15);
    }

    .forms-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .forms-action {
        border: 1px solid #344a78;
        background: #192b52;
        color: #dce7ff;
        padding: 7px 10px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
        cursor: pointer;
    }

    .forms-action:hover {
        color: #fff;
        background: #29477e;
    }

    .forms-action.delete {
        color: #fca5a5;
        border-color: #713b50;
        background: #3a1d36;
    }

    .forms-empty {
        text-align: center;
        padding: 45px 20px;
        color: #9eafd0;
    }

    .forms-alert {
        padding: 13px 16px;
        border-radius: 10px;
        margin-bottom: 18px;
        background: rgba(22, 163, 74, .14);
        border: 1px solid rgba(74, 222, 128, .3);
        color: #86efac;
    }

    .forms-pagination {
        padding: 18px;
        background: #101c39;
    }

    .forms-pagination nav {
        display: flex;
        justify-content: center;
    }

    .forms-pagination nav div:first-child {
        display: none;
    }

    .forms-pagination nav span,
    .forms-pagination nav a {
        background: #192b52 !important;
        color: #dce7ff !important;
        border-color: #344a78 !important;
    }

    @media(max-width: 700px) {
        .forms-page {
            padding: 15px;
        }

        .forms-stats {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="forms-page">

    <div class="forms-header">
        <div>
            <h2><i class="bi bi-folder2-open"></i> Downloadable Forms</h2>
            <p>Upload and publish forms that all cadets can download.</p>
        </div>

        <a href="{{ route('admin.downloadable-forms.create') }}"
           class="forms-btn">
            <i class="bi bi-cloud-upload"></i>
            Upload New Form
        </a>
    </div>

    @if(session('success'))
        <div class="forms-alert">
            <i class="bi bi-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="forms-alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="forms-stats">

        <div class="forms-stat">
            <small>Total Forms</small>
            <strong>{{ $totalForms }}</strong>
        </div>

        <div class="forms-stat">
            <small>Published Forms</small>
            <strong>{{ $publishedForms }}</strong>
        </div>

        <div class="forms-stat">
            <small>Draft Forms</small>
            <strong>{{ $draftForms }}</strong>
        </div>

    </div>

    <div class="forms-panel">

        <div class="forms-panel-heading">
            Uploaded Forms
        </div>

        <div class="forms-table-wrap">

            <table class="forms-table">

                <thead>
                    <tr>
                        <th>Form Title</th>
                        <th>File Name</th>
                        <th>File Size</th>
                        <th>Uploaded By</th>
                        <th>Date Uploaded</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($forms as $form)

                        <tr>
                            <td>
                                <strong>{{ $form->title }}</strong>

                                @if($form->description)
                                    <div class="forms-muted">
                                        {{ \Illuminate\Support\Str::limit($form->description, 55) }}
                                    </div>
                                @endif
                            </td>

                            <td>{{ $form->original_name }}</td>

                            <td>
                                {{ number_format($form->file_size / 1024, 1) }} KB
                            </td>

                            <td>
                                {{ $form->uploader->name ?? 'Unknown' }}
                            </td>

                            <td>
                                {{ $form->created_at->format('M d, Y') }}
                            </td>

                            <td>
                                @if($form->is_published)
                                    <span class="forms-status published">
                                        Published
                                    </span>
                                @else
                                    <span class="forms-status draft">
                                        Draft
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="forms-actions">

                                    <a href="{{ route('admin.downloadable-forms.edit', $form) }}"
                                       class="forms-action">
                                        <i class="bi bi-pencil-square"></i>
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.downloadable-forms.destroy', $form) }}"
                                          onsubmit="return confirm('Are you sure you want to delete this form?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="forms-action delete">
                                            <i class="bi bi-trash"></i>
                                            Delete
                                        </button>

                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7">
                                <div class="forms-empty">
                                    <i class="bi bi-folder-x"
                                       style="font-size:35px;"></i>

                                    <p>No downloadable forms have been uploaded yet.</p>
                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($forms->hasPages())
            <div class="forms-pagination">
                {{ $forms->links() }}
            </div>
        @endif

    </div>

</div>

@endsection