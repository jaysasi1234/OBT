
@extends('layouts.cadet')

@section('content')

<style>
    .cadet-forms-page {
        padding: 25px;
        color: #eaf0ff;
        min-height: 80vh;
    }

    .cadet-forms-header {
        margin-bottom: 25px;
    }

    .cadet-forms-header h2 {
        color: #fff;
        font-size: 26px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .cadet-forms-header p {
        color: #9eafd0;
        margin: 0;
    }

    .cadet-forms-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
        gap: 18px;
    }

    .cadet-form-card {
        background: #101c39;
        border: 1px solid #26375e;
        border-radius: 15px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        min-height: 245px;
        transition: .2s ease;
        min-width: 0;
    }

    .cadet-form-card:hover {
        transform: translateY(-3px);
        border-color: #527ce8;
        background: #142448;
    }

    .cadet-form-icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(59, 130, 246, .15);
        color: #75a5ff;
        font-size: 25px;
        margin-bottom: 16px;
    }

    .cadet-form-card h3 {
        color: #fff;
        font-size: 17px;
        font-weight: 800;
        margin-bottom: 8px;
        overflow-wrap: anywhere;
    }

    .cadet-form-description {
        color: #a9b9d8;
        font-size: 13px;
        line-height: 1.6;
        flex: 1;
        margin-bottom: 15px;
        white-space: pre-line;
        overflow-wrap: anywhere;
    }

    .cadet-form-meta {
        color: #8296bd;
        font-size: 11px;
        line-height: 1.8;
        margin-bottom: 15px;
    }

    .cadet-download-btn {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        width: 100%;
        padding: 11px 15px;
        border-radius: 9px;
        background: linear-gradient(135deg, #3867e8, #2448ad);
        color: white;
        text-decoration: none;
        font-weight: 700;
        transition: .2s ease;
    }

    .cadet-download-btn:hover {
        color: white;
        filter: brightness(1.12);
        transform: translateY(-1px);
    }

    .cadet-forms-empty {
        background: #101c39;
        border: 1px solid #26375e;
        border-radius: 15px;
        padding: 55px 20px;
        text-align: center;
        color: #9eafd0;
    }

    .cadet-forms-empty i {
        font-size: 45px;
        display: block;
        margin-bottom: 12px;
    }

    .cadet-forms-empty h3 {
        color: #fff;
    }

    .cadet-forms-pagination {
        margin-top: 25px;
    }

    .cadet-forms-pagination nav {
        display: flex;
        justify-content: center;
    }

    .cadet-forms-pagination nav div:first-child {
        display: none;
    }

    .cadet-forms-pagination nav span,
    .cadet-forms-pagination nav a {
        background: #192b52 !important;
        color: #dce7ff !important;
        border-color: #344a78 !important;
    }

    @media(max-width: 600px) {
        .cadet-forms-page {
            padding: 15px;
        }

        .cadet-forms-grid {
            grid-template-columns: 1fr;
        }

        .cadet-forms-header h2 {
            font-size: 22px;
        }
    }
</style>

<div class="cadet-forms-page">

    <div class="cadet-forms-header">
        <h2>
            <i class="bi bi-folder2-open"></i>
            Downloadable Forms
        </h2>

        <p>
            Download the forms and documents provided by the OBT administrator.
        </p>
    </div>

    @if(isset($forms) && $forms->count() > 0)

        <div class="cadet-forms-grid">

            @foreach($forms as $form)

                @php
                    $extension = strtolower(
                        pathinfo($form->original_name ?? '', PATHINFO_EXTENSION)
                    );

                    $icons = [
                        'pdf' => 'bi-file-earmark-pdf',
                        'doc' => 'bi-file-earmark-word',
                        'docx' => 'bi-file-earmark-word',
                        'xls' => 'bi-file-earmark-excel',
                        'xlsx' => 'bi-file-earmark-excel',
                        'ppt' => 'bi-file-earmark-ppt',
                        'pptx' => 'bi-file-earmark-ppt',
                        'jpg' => 'bi-file-earmark-image',
                        'jpeg' => 'bi-file-earmark-image',
                        'png' => 'bi-file-earmark-image',
                    ];

                    $icon = $icons[$extension] ?? 'bi-file-earmark';

                    $fileSize = (float) ($form->file_size ?? 0);
                @endphp

                <div class="cadet-form-card">

                    <div class="cadet-form-icon">
                        <i class="bi {{ $icon }}"></i>
                    </div>

                    <h3>{{ $form->title }}</h3>

                    <div class="cadet-form-description">
                        {{ $form->description ?: 'No description provided.' }}
                    </div>

                    <div class="cadet-form-meta">

                        <i class="bi bi-file-earmark"></i>

                        {{ $extension ? strtoupper($extension) : 'FILE' }}

                        &nbsp;·&nbsp;

                        {{ number_format($fileSize / 1024, 1) }} KB

                        <br>

                        <i class="bi bi-calendar3"></i>

                        Posted {{ optional($form->created_at)->format('M d, Y') }}

                    </div>

                    <a href="{{ route('cadet.downloadable-forms.download', $form->id) }}"
                       class="cadet-download-btn">

                        <i class="bi bi-download"></i>

                        Download Form

                    </a>

                </div>

            @endforeach

        </div>

        @if(method_exists($forms, 'hasPages') && $forms->hasPages())

            <div class="cadet-forms-pagination">
                {{ $forms->links() }}
            </div>

        @endif

    @else

        <div class="cadet-forms-empty">

            <i class="bi bi-folder-x"></i>

            <h3>No Forms Available</h3>

            <p>
                There are currently no published forms.
                Please check again later.
            </p>

        </div>

    @endif

</div>

@endsection
