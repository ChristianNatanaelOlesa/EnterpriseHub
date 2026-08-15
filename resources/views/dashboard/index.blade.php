@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="row g-3">

        {{-- Company --}}

        <div class="col-xl-3 col-md-6">

            <div class="small-box text-bg-primary">

                <div class="inner">

                    <h3>{{ $companyCount }}</h3>

                    <p>Company</p>

                </div>

                <div class="small-box-icon">

                    <i class="bi bi-building"></i>

                </div>

            </div>

        </div>


        {{-- Directorate --}}

        <div class="col-xl-3 col-md-6">

            <div class="small-box text-bg-success">

                <div class="inner">

                    <h3>{{ $directorateCount }}</h3>

                    <p>Directorate</p>

                </div>

                <div class="small-box-icon">

                    <i class="bi bi-diagram-3"></i>

                </div>

            </div>

        </div>


        {{-- Division --}}

        <div class="col-xl-3 col-md-6">

            <div class="small-box text-bg-warning">

                <div class="inner">

                    <h3>{{ $divisionCount }}</h3>

                    <p>Division</p>

                </div>

                <div class="small-box-icon">

                    <i class="bi bi-diagram-2"></i>

                </div>

            </div>

        </div>


        {{-- Department --}}

        <div class="col-xl-3 col-md-6">

            <div class="small-box text-bg-info">

                <div class="inner">

                    <h3>{{ $departmentCount }}</h3>

                    <p>Department</p>

                </div>

                <div class="small-box-icon">

                    <i class="bi bi-diagram-3-fill"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- Security Statistics --}}

    <div class="row g-3 mt-1">

        {{-- Users --}}

        <div class="col-xl-4 col-md-6">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6 class="text-muted mb-2">

                                Total Users

                            </h6>

                            <h2 class="mb-0">

                                {{ $userCount }}

                            </h2>

                        </div>

                        <div class="fs-1 text-primary">

                            <i class="bi bi-people"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Roles --}}

        <div class="col-xl-4 col-md-6">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6 class="text-muted mb-2">

                                Total Roles

                            </h6>

                            <h2 class="mb-0">

                                {{ $roleCount }}

                            </h2>

                        </div>

                        <div class="fs-1 text-success">

                            <i class="bi bi-shield-lock"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Active Users --}}

        <div class="col-xl-4 col-md-6">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6 class="text-muted mb-2">

                                Active Users

                            </h6>

                            <h2 class="mb-0">

                                {{ $activeUserCount }}

                            </h2>

                        </div>

                        <div class="fs-1 text-info">

                            <i class="bi bi-person-check"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Quick Access --}}

    <div class="card mt-4">

        <div class="card-header">

            <h5 class="mb-0">

                Quick Access

            </h5>

        </div>

        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-3">

                    <a href="{{ route('master.company.index') }}" class="btn btn-outline-primary w-100">

                        <i class="bi bi-building me-1"></i>

                        Companies

                    </a>

                </div>

                <div class="col-md-3">

                    <a href="{{ route('master.directorate.index') }}" class="btn btn-outline-success w-100">

                        <i class="bi bi-diagram-3 me-1"></i>

                        Directorates

                    </a>

                </div>

                <div class="col-md-3">

                    <a href="{{ route('master.division.index') }}" class="btn btn-outline-warning w-100">

                        <i class="bi bi-diagram-2 me-1"></i>

                        Divisions

                    </a>

                </div>

                <div class="col-md-3">

                    <a href="{{ route('master.department.index') }}" class="btn btn-outline-info w-100">

                        <i class="bi bi-diagram-3-fill me-1"></i>

                        Departments

                    </a>

                </div>

            </div>

        </div>

    </div>

@endsection
