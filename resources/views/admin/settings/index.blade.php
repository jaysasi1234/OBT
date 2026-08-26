@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/settings/settings.css'])


<div class="settings-page">

    <div class="settings-container">

        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="settings-header">

            <div class="settings-header-left">

                <div class="settings-eyebrow">

                    <i class="bi bi-shield-check"></i>

                    Administration

                </div>

                <h1 class="settings-title">
                    System Settings
                </h1>

                <p class="settings-description">
                    Manage system configuration, cadet requirements,
                    user accounts, academic information, and reporting
                    preferences from one centralized control panel.
                </p>

            </div>


            <div class="system-status">

                <span class="system-status-dot"></span>

                System Configuration

            </div>

        </div>


        {{-- =====================================================
             SEARCH
        ====================================================== --}}

        <div class="settings-toolbar">

            <div class="settings-search">

                <i class="bi bi-search"></i>

                <input
                    type="search"
                    id="settingsSearch"
                    placeholder="Search settings..."
                    autocomplete="off"
                >

            </div>

        </div>


        {{-- =====================================================
             GENERAL ADMINISTRATION
        ====================================================== --}}

        <section
            class="settings-section"
            data-section
        >

            <div class="section-heading">

                <span>
                    General Administration
                </span>

            </div>


            <div class="settings-grid">


                {{-- SYSTEM SETTINGS --}}

                <div class="settings-card" data-card>

                    <div class="card-top">

                        <div class="settings-icon icon-indigo">

                            <i class="bi bi-gear-fill"></i>

                        </div>

                        <div class="card-arrow">

                            <i class="bi bi-arrow-up-right"></i>

                        </div>

                    </div>

                    <h3>
                        System Settings
                    </h3>

                    <p>
                        Configure system information, application
                        preferences, and general platform settings.
                    </p>

                    <span class="card-tag">
                        System
                    </span>

                    <a
                        href="{{ route('admin.system.settings') }}"
                        class="card-action"
                    >
                        Manage Settings
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>


                {{-- USER ACCOUNTS --}}

                <div class="settings-card" data-card>

                    <div class="card-top">

                        <div class="settings-icon icon-green">

                            <i class="bi bi-people-fill"></i>

                        </div>

                        <div class="card-arrow">

                            <i class="bi bi-arrow-up-right"></i>

                        </div>

                    </div>

                    <h3>
                        User Account Management
                    </h3>

                    <p>
                        Create, manage, activate, deactivate, and
                        maintain system user accounts and access.
                    </p>

                    <span class="card-tag">
                        Accounts
                    </span>

                    <a
                        href="{{ route('admin.users.index') }}"
                        class="card-action"
                    >
                        Manage Accounts
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>


                {{-- ACCOUNT CREDENTIALS --}}

                <div class="settings-card" data-card>

                    <div class="card-top">

                        <div class="settings-icon icon-purple">

                            <i class="bi bi-key-fill"></i>

                        </div>

                        <div class="card-arrow">

                            <i class="bi bi-arrow-up-right"></i>

                        </div>

                    </div>

                    <h3>
                        Account Credentials
                    </h3>

                    <p>
                        Manage usernames, email addresses, and
                        temporary credentials for system users.
                    </p>

                    <span class="card-tag">
                        Security
                    </span>

                    <a
                        href="{{ route('admin.settings.account-credentials') }}"
                        class="card-action"
                    >
                        Manage Credentials
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>

        </section>


        {{-- =====================================================
             ACADEMIC MANAGEMENT
        ====================================================== --}}

        <section
            class="settings-section"
            data-section
        >

            <div class="section-heading">

                <span>
                    Academic Management
                </span>

            </div>


            <div class="settings-grid">


                {{-- COURSE --}}

                <div class="settings-card" data-card>

                    <div class="card-top">

                        <div class="settings-icon icon-orange">

                            <i class="bi bi-mortarboard-fill"></i>

                        </div>

                        <div class="card-arrow">

                            <i class="bi bi-arrow-up-right"></i>

                        </div>

                    </div>

                    <h3>
                        Course Management
                    </h3>

                    <p>
                        Manage academic courses, course names,
                        and program information used by cadets.
                    </p>

                    <span class="card-tag">
                        Academic
                    </span>

                    <a
                        href="{{ route('admin.course.management') }}"
                        class="card-action"
                    >
                        Manage Courses
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>


                {{-- BATCH --}}

                <div class="settings-card" data-card>

                    <div class="card-top">

                        <div class="settings-icon icon-pink">

                            <i class="bi bi-calendar3"></i>

                        </div>

                        <div class="card-arrow">

                            <i class="bi bi-arrow-up-right"></i>

                        </div>

                    </div>

                    <h3>
                        Batch Management
                    </h3>

                    <p>
                        Create and manage cadet batches and
                        their corresponding academic years.
                    </p>

                    <span class="card-tag">
                        Academic
                    </span>

                    <a
                        href="{{ route('admin.batch.management') }}"
                        class="card-action"
                    >
                        Manage Batches
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>

        </section>


        {{-- =====================================================
             CADET REQUIREMENTS
        ====================================================== --}}

        <section
            class="settings-section"
            data-section
        >

            <div class="section-heading">

                <span>
                    Cadet Requirements
                </span>

            </div>


            <div class="settings-grid">


                {{-- REQUIREMENTS --}}

                <div class="settings-card" data-card>

                    <div class="card-top">

                        <div class="settings-icon icon-cyan">

                            <i class="bi bi-file-earmark-check-fill"></i>

                        </div>

                        <div class="card-arrow">

                            <i class="bi bi-arrow-up-right"></i>

                        </div>

                    </div>

                    <h3>
                        Requirements Settings
                    </h3>

                    <p>
                        Configure required documents and verification
                        requirements for cadets.
                    </p>

                    <span class="card-tag">
                        Verification
                    </span>

                    <a
                        href="{{ route('admin.requirements.index') }}"
                        class="card-action"
                    >
                        Manage Requirements
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>


                {{-- ONBOARD REQUIREMENTS --}}

                <div class="settings-card" data-card>

                    <div class="card-top">

                        <div class="settings-icon icon-blue">

                            <i class="bi bi-clipboard2-check-fill"></i>

                        </div>

                        <div class="card-arrow">

                            <i class="bi bi-arrow-up-right"></i>

                        </div>

                    </div>

                    <h3>
                        Onboard Requirements
                    </h3>

                    <p>
                        Manage onboard requirement templates,
                        submission schedules, frequencies, and documents.
                    </p>

                    <span class="card-tag">
                        OBT
                    </span>

                    <a
                        href="{{ route('admin.settings.onboard-requirements.index') }}"
                        class="card-action"
                    >
                        Manage Requirements
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>


                {{-- BS REQUIREMENTS --}}

                <div class="settings-card" data-card>

                    <div class="card-top">

                        <div class="settings-icon icon-teal">

                            <i class="bi bi-folder-check"></i>

                        </div>

                        <div class="card-arrow">

                            <i class="bi bi-arrow-up-right"></i>

                        </div>

                    </div>

                    <h3>
                        BS Requirements
                    </h3>

                    <p>
                        Manage post-deployment BS requirements
                        and documents required after onboard training.
                    </p>

                    <span class="card-tag">
                        Post-Deployment
                    </span>

                    <a
                        href="{{ route('admin.bs-requirements.index') }}"
                        class="card-action"
                    >
                        Manage Requirements
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>

        </section>


        {{-- =====================================================
             REPORTING & CONCERNS
        ====================================================== --}}

        <section
            class="settings-section"
            data-section
        >

            <div class="section-heading">

                <span>
                    Reporting & Concerns
                </span>

            </div>


            <div class="settings-grid">


                {{-- COMPLAINT TYPES --}}

                <div class="settings-card" data-card>

                    <div class="card-top">

                        <div class="settings-icon icon-red">

                            <i class="bi bi-exclamation-triangle-fill"></i>

                        </div>

                        <div class="card-arrow">

                            <i class="bi bi-arrow-up-right"></i>

                        </div>

                    </div>

                    <h3>
                        Complaint Type Settings
                    </h3>

                    <p>
                        Configure complaint categories and concern
                        types used throughout the system.
                    </p>

                    <span class="card-tag">
                        Concerns
                    </span>

                    <a
                        href="{{ route('admin.complaint.types.index') }}"
                        class="card-action"
                    >
                        Manage Complaints
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>


                {{-- REPORT SETTINGS --}}

                <div class="settings-card" data-card>

                    <div class="card-top">

                        <div class="settings-icon icon-purple">

                            <i class="bi bi-bar-chart-fill"></i>

                        </div>

                        <div class="card-arrow">

                            <i class="bi bi-arrow-up-right"></i>

                        </div>

                    </div>

                    <h3>
                        Report Settings
                    </h3>

                    <p>
                        Configure report types, reporting options,
                        and display preferences.
                    </p>

                    <span class="card-tag">
                        Reporting
                    </span>

                    <a
                        href="{{ route('admin.report.settings') }}"
                        class="card-action"
                    >
                        Manage Reports
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>

        </section>


        {{-- SEARCH EMPTY STATE --}}

        <div
            class="settings-empty"
            id="settingsEmpty"
        >

            <i class="bi bi-search"></i>

            No settings found.

        </div>

    </div>

</div>


<script>

/* =========================================================
   SETTINGS SEARCH
========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('settingsSearch');
    const cards = document.querySelectorAll('[data-card]');
    const sections = document.querySelectorAll('[data-section]');
    const emptyState = document.getElementById('settingsEmpty');

    if (!searchInput) {
        return;
    }

    searchInput.addEventListener('input', function () {

        const query = this.value
            .trim()
            .toLowerCase();

        let visibleCards = 0;

        cards.forEach(function (card) {

            const text = card.textContent
                .toLowerCase();

            const matches = text.includes(query);

            card.style.display = matches
                ? ''
                : 'none';

            if (matches) {
                visibleCards++;
            }

        });


        sections.forEach(function (section) {

            const sectionCards =
                section.querySelectorAll('[data-card]');

            const hasVisibleCard =
                Array.from(sectionCards)
                    .some(function (card) {
                        return card.style.display !== 'none';
                    });

            section.style.display =
                hasVisibleCard
                    ? ''
                    : 'none';

        });


        if (query && visibleCards === 0) {

            emptyState.style.display = 'block';

        } else {

            emptyState.style.display = 'none';

        }

    });

});

</script>

@endsection