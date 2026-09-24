@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="eh-page-header mb-4">
        <div>
            <h1 class="eh-page-title mb-1">Dashboard</h1>
            <p class="eh-page-subtitle mb-0">Overview of your EnterpriseHub workspace.</p>
        </div>
    </div>

    {{-- Organization Statistics --}}
    <div class="row g-3 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="eh-stat-card eh-stat-blue">
                <div class="eh-stat-icon">
                    <i class="bi bi-building"></i>
                </div>
                <div class="eh-stat-content">
                    <span class="eh-stat-label">Company</span>
                    <strong class="eh-stat-value">{{ $companyCount }}</strong>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="eh-stat-card eh-stat-green">
                <div class="eh-stat-icon">
                    <i class="bi bi-diagram-3"></i>
                </div>
                <div class="eh-stat-content">
                    <span class="eh-stat-label">Directorate</span>
                    <strong class="eh-stat-value">{{ $directorateCount }}</strong>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="eh-stat-card eh-stat-amber">
                <div class="eh-stat-icon">
                    <i class="bi bi-diagram-2"></i>
                </div>
                <div class="eh-stat-content">
                    <span class="eh-stat-label">Division</span>
                    <strong class="eh-stat-value">{{ $divisionCount }}</strong>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="eh-stat-card eh-stat-cyan">
                <div class="eh-stat-icon">
                    <i class="bi bi-diagram-3-fill"></i>
                </div>
                <div class="eh-stat-content">
                    <span class="eh-stat-label">Department</span>
                    <strong class="eh-stat-value">{{ $departmentCount }}</strong>
                </div>
            </div>
        </div>

    </div>

    {{-- Security Statistics --}}
    <div class="section-heading mb-3">
        <h5 class="mb-0">Security Overview</h5>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-xl-4 col-md-6">
            <div class="eh-info-card">
                <div>
                    <span class="eh-info-label">Total Users</span>
                    <strong class="eh-info-value">{{ $userCount }}</strong>
                </div>
                <div class="eh-info-icon eh-icon-blue">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="eh-info-card">
                <div>
                    <span class="eh-info-label">Total Roles</span>
                    <strong class="eh-info-value">{{ $roleCount }}</strong>
                </div>
                <div class="eh-info-icon eh-icon-green">
                    <i class="bi bi-shield-lock"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="eh-info-card">
                <div>
                    <span class="eh-info-label">Active Users</span>
                    <strong class="eh-info-value">{{ $activeUserCount }}</strong>
                </div>
                <div class="eh-info-icon eh-icon-cyan">
                    <i class="bi bi-person-check"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- Quick Access --}}
    <div class="eh-panel">
        <div class="eh-panel-header">
            <div>
                <h5 class="mb-1">Quick Access</h5>
                <p class="mb-0">Open frequently used master data.</p>
            </div>
        </div>

        <div class="eh-panel-body">
            <div class="row g-3">

                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('master.company.index') }}" class="eh-quick-link">
                        <span class="eh-quick-icon eh-icon-blue">
                            <i class="bi bi-building"></i>
                        </span>
                        <span>
                            <strong>Companies</strong>
                            <small>Manage company data</small>
                        </span>
                        <i class="bi bi-arrow-right ms-auto"></i>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('master.directorate.index') }}" class="eh-quick-link">
                        <span class="eh-quick-icon eh-icon-green">
                            <i class="bi bi-diagram-3"></i>
                        </span>
                        <span>
                            <strong>Directorates</strong>
                            <small>Manage directorates</small>
                        </span>
                        <i class="bi bi-arrow-right ms-auto"></i>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('master.division.index') }}" class="eh-quick-link">
                        <span class="eh-quick-icon eh-icon-amber">
                            <i class="bi bi-diagram-2"></i>
                        </span>
                        <span>
                            <strong>Divisions</strong>
                            <small>Manage divisions</small>
                        </span>
                        <i class="bi bi-arrow-right ms-auto"></i>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('master.department.index') }}" class="eh-quick-link">
                        <span class="eh-quick-icon eh-icon-cyan">
                            <i class="bi bi-diagram-3-fill"></i>
                        </span>
                        <span>
                            <strong>Departments</strong>
                            <small>Manage departments</small>
                        </span>
                        <i class="bi bi-arrow-right ms-auto"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>

@endsection
