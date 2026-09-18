<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $companyCount = DB::table('ms_company')
            ->count();

        $directorateCount = DB::table('ms_directorate')
            ->count();

        $divisionCount = DB::table('ms_division')
            ->count();

        $departmentCount = DB::table('ms_department')
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
