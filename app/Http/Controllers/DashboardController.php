<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $companyCount = DB::table('ms_company')
            ->whereNull('DeletedDate')
            ->count();

        $directorateCount = DB::table('ms_directorate')
            ->whereNull('DeletedDate')
            ->count();

        $divisionCount = DB::table('ms_division')
            ->whereNull('DeletedDate')
            ->count();

        $departmentCount = DB::table('ms_department')
            ->whereNull('DeletedDate')
            ->count();

        $userCount = DB::table('sc_user')
            ->whereNull('DeletedDate')
            ->count();

        $roleCount = DB::table('sc_role')
            ->whereNull('DeletedDate')
            ->count();

        $activeUserCount = DB::table('sc_user')
            ->whereNull('DeletedDate')
            ->where('IsActive', true)
            ->count();

        return view('dashboard.index', compact(
            'companyCount',
            'directorateCount',
            'divisionCount',
            'departmentCount',
            'userCount',
            'roleCount',
            'activeUserCount'
        ));
    }
}
