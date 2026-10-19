<?php

namespace App\Http\Controllers\EForm;

use App\Http\Controllers\Controller;
use App\Http\Requests\EForm\StoreEmployeeFormRequest;
use App\Models\EForm\TrEmpForm;
use App\Models\EForm\TrEmpFormHist;
use App\Models\Master\MsCity;
use App\Models\Master\MsCountry;
use App\Models\Master\MsDepartment;
use App\Models\Master\MsDirectorate;
use App\Models\Master\MsDistrict;
use App\Models\Master\MsDivision;
use App\Models\Master\MsJobLevel;
use App\Models\Master\MsJobTitle;
use App\Models\Master\MsProvince;
use App\Models\Master\MsReligion;
use App\Models\Master\MsVillage;
use App\Models\Security\ScUser;
use App\Services\EForm\EmployeeFormService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeFormController extends Controller
{
    public function __construct(
        protected EmployeeFormService $employeeFormService
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        /*
        |--------------------------------------------------------------------------
        | Universal Search
        |--------------------------------------------------------------------------
        |
        | Search seluruh field yang tersedia pada Employee Form dan History,
        | termasuk master Religion, Village, Organization, dan Job Master.
        |
        */

        $employeeQuery = TrEmpForm::query()
            ->with([
                'religion',
                'village',
                'histories' => function ($query) {
                    $query
                        ->with([
                            'directorate',
                            'division',
                            'department',
                            'jobLevel',
                            'jobTitle',
                        ])
                        ->orderByDesc('EffectiveDate')
                        ->orderByDesc('EmpFormHistID');
                },
            ]);

        if ($search !== '') {
            $like = '%' . $search . '%';

            /*
            |--------------------------------------------------------------------------
            | Address hierarchy search
            |--------------------------------------------------------------------------
            |
            | Karena Tr_EmpForm hanya menyimpan VillageID, kita cari VillageID
            | yang cocok berdasarkan Village, District, City, Province, atau Country.
            |
            */

            $matchedVillageIds = MsVillage::query()
                ->where('Village', 'like', $like)
                ->pluck('VillageID');

            $matchedDistrictIds = MsDistrict::query()
                ->where('District', 'like', $like)
                ->pluck('DistrictID');

            if ($matchedDistrictIds->isNotEmpty()) {
                $matchedVillageIds = $matchedVillageIds->merge(
                    MsVillage::query()
                        ->whereIn('DistrictID', $matchedDistrictIds)
                        ->pluck('VillageID')
                );
            }

            $matchedCityIds = MsCity::query()
                ->where('City', 'like', $like)
                ->pluck('CityID');

            if ($matchedCityIds->isNotEmpty()) {
                $matchedDistrictIdsByCity = MsDistrict::query()
                    ->whereIn('CityID', $matchedCityIds)
                    ->pluck('DistrictID');

                $matchedVillageIds = $matchedVillageIds->merge(
                    MsVillage::query()
                        ->whereIn(
                            'DistrictID',
                            $matchedDistrictIdsByCity
                        )
                        ->pluck('VillageID')
                );
            }

            $matchedProvinceIds = MsProvince::query()
                ->where('Province', 'like', $like)
                ->pluck('ProvinceID');

            if ($matchedProvinceIds->isNotEmpty()) {
                $matchedCityIdsByProvince = MsCity::query()
                    ->whereIn(
                        'ProvinceID',
                        $matchedProvinceIds
                    )
                    ->pluck('CityID');

                $matchedDistrictIdsByProvince = MsDistrict::query()
                    ->whereIn(
                        'CityID',
                        $matchedCityIdsByProvince
                    )
                    ->pluck('DistrictID');

                $matchedVillageIds = $matchedVillageIds->merge(
                    MsVillage::query()
                        ->whereIn(
                            'DistrictID',
                            $matchedDistrictIdsByProvince
                        )
                        ->pluck('VillageID')
                );
            }

            $matchedCountryIds = MsCountry::query()
                ->where('Country', 'like', $like)
                ->pluck('CountryID');

            if ($matchedCountryIds->isNotEmpty()) {
                $matchedProvinceIdsByCountry = MsProvince::query()
                    ->whereIn(
                        'CountryID',
                        $matchedCountryIds
                    )
                    ->pluck('ProvinceID');

                $matchedCityIdsByCountry = MsCity::query()
                    ->whereIn(
                        'ProvinceID',
                        $matchedProvinceIdsByCountry
                    )
                    ->pluck('CityID');

                $matchedDistrictIdsByCountry = MsDistrict::query()
                    ->whereIn(
                        'CityID',
                        $matchedCityIdsByCountry
                    )
                    ->pluck('DistrictID');

                $matchedVillageIds = $matchedVillageIds->merge(
                    MsVillage::query()
                        ->whereIn(
                            'DistrictID',
                            $matchedDistrictIdsByCountry
                        )
                        ->pluck('VillageID')
                );
            }

            $matchedVillageIds = $matchedVillageIds
                ->filter()
                ->unique()
                ->values();

            $employeeQuery->where(function ($query) use (
                $like,
                $matchedVillageIds
            ) {
                /*
                |--------------------------------------------------------------------------
                | Tr_EmpForm fields
                |--------------------------------------------------------------------------
                */

                $query
                    ->where('EmpFormID', 'like', $like)
                    ->orWhere('FirstName', 'like', $like)
                    ->orWhere('LastName', 'like', $like)
                    ->orWhere('MobileNo', 'like', $like)
                    ->orWhere('BirthDate', 'like', $like)
                    ->orWhere('NIP', 'like', $like)
                    ->orWhere('MaritalStatus', 'like', $like)
                    ->orWhere('JoinDate', 'like', $like)
                    ->orWhere('Address', 'like', $like)
                    ->orWhere('Email', 'like', $like)
                    ->orWhere('InputUser', 'like', $like)
                    ->orWhere('ModifUser', 'like', $like);

                /*
                |--------------------------------------------------------------------------
                | Religion
                |--------------------------------------------------------------------------
                */

                $query->orWhereHas(
                    'religion',
                    function ($religionQuery) use ($like) {
                        $religionQuery
                            ->where(
                                'ReligionID',
                                'like',
                                $like
                            )
                            ->orWhere(
                                'Religion',
                                'like',
                                $like
                            );
                    }
                );

                /*
                |--------------------------------------------------------------------------
                | Address
                |--------------------------------------------------------------------------
                */

                if ($matchedVillageIds->isNotEmpty()) {
                    $query->orWhereIn(
                        'VillageID',
                        $matchedVillageIds
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Employment / History
                |--------------------------------------------------------------------------
                */

                $query->orWhereHas(
                    'histories',
                    function ($historyQuery) use ($like) {
                        $historyQuery
                            ->where(
                                'EmpFormHistID',
                                'like',
                                $like
                            )
                            ->orWhere(
                                'EmpFormID',
                                'like',
                                $like
                            )
                            ->orWhere(
                                'ReportTo',
                                'like',
                                $like
                            )
                            ->orWhere(
                                'EmpStatus',
                                'like',
                                $like
                            )
                            ->orWhere(
                                'EffectiveDate',
                                'like',
                                $like
                            )
                            ->orWhere(
                                'Remarks',
                                'like',
                                $like
                            )
                            ->orWhere(
                                'like',
                                $like
                            )
                            ->orWhere(
                                'ReqDate',
                                'like',
                                $like
                            )
                            ->orWhere(
                                'Status',
                                'like',
                                $like
                            )
                            ->orWhere(
                                'ProcessID',
                                'like',
                                $like
                            )
                            ->orWhere(
                                'CurrentStateID',
                                'like',
                                $like
                            )
                            ->orWhereHas(
                                'directorate',
                                function ($q) use ($like) {
                                    $q->where(
                                        'Directorate',
                                        'like',
                                        $like
                                    );
                                }
                            )
                            ->orWhereHas(
                                'division',
                                function ($q) use ($like) {
                                    $q->where(
                                        'Division',
                                        'like',
                                        $like
                                    );
                                }
                            )
                            ->orWhereHas(
                                'department',
                                function ($q) use ($like) {
                                    $q->where(
                                        'Department',
                                        'like',
                                        $like
                                    );
                                }
                            )
                            ->orWhereHas(
                                'jobLevel',
                                function ($q) use ($like) {
                                    $q->where(
                                        'JobLevel',
                                        'like',
                                        $like
                                    );
                                }
                            )
                            ->orWhereHas(
                                'jobTitle',
                                function ($q) use ($like) {
                                    $q->where(
                                        'JobTitle',
                                        'like',
                                        $like
                                    );
                                }
                            );
                    }
                );
            });
        }

        $employeeForms = $employeeQuery
            ->orderByDesc('InputDate')
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Address hierarchy for current page
        |--------------------------------------------------------------------------
        */

        $villageIds = $employeeForms
            ->getCollection()
            ->pluck('VillageID')
            ->filter()
            ->unique()
            ->values();

        $villages = collect();
        $districts = collect();
        $cities = collect();
        $provinces = collect();
        $countries = collect();

        if ($villageIds->isNotEmpty()) {
            $villages = MsVillage::query()
                ->whereIn('VillageID', $villageIds)
                ->get()
                ->keyBy('VillageID');

            $districtIds = $villages
                ->pluck('DistrictID')
                ->filter()
                ->unique()
                ->values();

            if ($districtIds->isNotEmpty()) {
                $districts = MsDistrict::query()
                    ->whereIn('DistrictID', $districtIds)
                    ->get()
                    ->keyBy('DistrictID');

                $cityIds = $districts
                    ->pluck('CityID')
                    ->filter()
                    ->unique()
                    ->values();

                if ($cityIds->isNotEmpty()) {
                    $cities = MsCity::query()
                        ->whereIn('CityID', $cityIds)
                        ->get()
                        ->keyBy('CityID');

                    $provinceIds = $cities
                        ->pluck('ProvinceID')
                        ->filter()
                        ->unique()
                        ->values();

                    if ($provinceIds->isNotEmpty()) {
                        $provinces = MsProvince::query()
                            ->whereIn(
                                'ProvinceID',
                                $provinceIds
                            )
                            ->get()
                            ->keyBy('ProvinceID');

                        $countryIds = $provinces
                            ->pluck('CountryID')
                            ->filter()
                            ->unique()
                            ->values();

                        if ($countryIds->isNotEmpty()) {
                            $countries = MsCountry::query()
                                ->whereIn(
                                    'CountryID',
                                    $countryIds
                                )
                                ->get()
                                ->keyBy('CountryID');
                        }
                    }
                }
            }
        }

        $employeeForms->getCollection()->transform(
            function (TrEmpForm $employeeForm) use (
                $villages,
                $districts,
                $cities,
                $provinces,
                $countries
            ) {
                $village = $villages->get(
                    $employeeForm->VillageID
                );

                $district = $village
                    ? $districts->get($village->DistrictID)
                    : null;

                $city = $district
                    ? $cities->get($district->CityID)
                    : null;

                $province = $city
                    ? $provinces->get($city->ProvinceID)
                    : null;

                $country = $province
                    ? $countries->get($province->CountryID)
                    : null;

                $employeeForm->setAttribute(
                    'detailVillage',
                    $village
                );

                $employeeForm->setAttribute(
                    'detailDistrict',
                    $district
                );

                $employeeForm->setAttribute(
                    'detailCity',
                    $city
                );

                $employeeForm->setAttribute(
                    'detailProvince',
                    $province
                );

                $employeeForm->setAttribute(
                    'detailCountry',
                    $country
                );

                return $employeeForm;
            }
        );

        return view(
            'eform.employee-form.index',
            compact(
                'employeeForms',
                'search'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        $countries = MsCountry::query()
            ->orderBy('Country')
            ->get();

        $provinces = MsProvince::query()
            ->where('CountryID', 'IDN')
            ->orderBy('Province')
            ->get();

        $religions = MsReligion::query()
            ->orderBy('Religion')
            ->get();

        $directorates = MsDirectorate::query()
            ->orderBy('Directorate')
            ->get();

        $jobLevels = MsJobLevel::query()
            ->orderBy('JobLevel')
            ->get();

        $jobTitles = MsJobTitle::query()
            ->orderBy('JobTitle')
            ->get();

        return view(
            'eform.employee-form.create',
            compact(
                'countries',
                'provinces',
                'religions',
                'directorates',
                'jobLevels',
                'jobTitles'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(
        StoreEmployeeFormRequest $request
    ): RedirectResponse {
        $inputUser = auth()->user()?->Username
            ?? auth()->user()?->username
            ?? 'Admin';

        $this->employeeFormService->create(
            $request->validated(),
            $inputUser
        );

        return redirect()
            ->route('employee-form.index')
            ->with(
                'success',
                'Employee Form Request berhasil dibuat.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(string $empFormId): View
    {
        $empFormId = trim($empFormId);

        $employeeForm = TrEmpForm::query()
            ->with([
                'histories' => function ($query) {
                    $query
                        ->orderByDesc('EffectiveDate')
                        ->orderByDesc('EmpFormHistID');
                },
            ])
            ->whereRaw(
                'TRIM(EmpFormID) = ?',
                [$empFormId]
            )
            ->firstOrFail();

        $history = $employeeForm->histories->first();

        $village = null;
        $district = null;
        $city = null;
        $province = null;

        if ($employeeForm->VillageID) {
            $village = MsVillage::query()
                ->where(
                    'VillageID',
                    $employeeForm->VillageID
                )
                ->first();

            if ($village) {
                $district = MsDistrict::query()
                    ->where(
                        'DistrictID',
                        $village->DistrictID
                    )
                    ->first();
            }

            if ($district) {
                $city = MsCity::query()
                    ->where(
                        'CityID',
                        $district->CityID
                    )
                    ->first();
            }

            if ($city) {
                $province = MsProvince::query()
                    ->where(
                        'ProvinceID',
                        $city->ProvinceID
                    )
                    ->first();
            }
        }

        $countries = MsCountry::query()
            ->orderBy('Country')
            ->get();

        $provinces = MsProvince::query()
            ->where(
                'CountryID',
                $province?->CountryID ?? 'IDN'
            )
            ->orderBy('Province')
            ->get();

        $cities = $province
            ? MsCity::query()
                ->where(
                    'ProvinceID',
                    $province->ProvinceID
                )
                ->orderBy('City')
                ->get()
            : collect();

        $districts = $city
            ? MsDistrict::query()
                ->where(
                    'CityID',
                    $city->CityID
                )
                ->orderBy('District')
                ->get()
            : collect();

        $villages = $district
            ? MsVillage::query()
                ->where(
                    'DistrictID',
                    $district->DistrictID
                )
                ->orderBy('Village')
                ->get()
            : collect();

        $religions = MsReligion::query()
            ->orderBy('Religion')
            ->get();

        $directorates = MsDirectorate::query()
            ->orderBy('Directorate')
            ->get();

        $divisions = MsDivision::query()
            ->where(
                'DirID',
                $history?->DirID
            )
            ->orderBy('Division')
            ->get();

        $departments = MsDepartment::query()
            ->where(
                'DivID',
                $history?->DivID
            )
            ->orderBy('Department')
            ->get();

        $jobLevels = MsJobLevel::query()
            ->orderBy('JobLevel')
            ->get();

        $jobTitles = MsJobTitle::query()
            ->orderBy('JobTitle')
            ->get();

        return view(
            'eform.employee-form.edit',
            compact(
                'employeeForm',
                'history',
                'countries',
                'provinces',
                'cities',
                'districts',
                'villages',
                'province',
                'city',
                'district',
                'village',
                'religions',
                'directorates',
                'divisions',
                'departments',
                'jobLevels',
                'jobTitles'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        StoreEmployeeFormRequest $request,
        string $empFormId
    ): RedirectResponse {
        $modifUser = auth()->user()?->Username
            ?? auth()->user()?->username
            ?? 'Admin';

        $this->employeeFormService->update(
            trim($empFormId),
            $request->validated(),
            $modifUser
        );

        return redirect()
            ->route('employee-form.index')
            ->with(
                'success',
                'Employee Form Request berhasil diubah.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(
        string $empFormId
    ): RedirectResponse {
        $this->employeeFormService->delete(
            trim($empFormId)
        );

        return redirect()
            ->route('employee-form.index')
            ->with(
                'success',
                'Employee Form Request berhasil dihapus.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ADDRESS CASCADING
    |--------------------------------------------------------------------------
    */

    public function provinces(string $countryId): JsonResponse
    {
        return response()->json(
            MsProvince::query()
                ->where('CountryID', $countryId)
                ->orderBy('Province')
                ->get([
                    'ProvinceID',
                    'Province',
                ])
        );
    }

    public function cities(string $provinceId): JsonResponse
    {
        return response()->json(
            MsCity::query()
                ->where('ProvinceID', $provinceId)
                ->orderBy('City')
                ->get([
                    'CityID',
                    'City',
                ])
        );
    }

    public function districts(string $cityId): JsonResponse
    {
        return response()->json(
            MsDistrict::query()
                ->where('CityID', $cityId)
                ->orderBy('District')
                ->get([
                    'DistrictID',
                    'District',
                ])
        );
    }

    public function villages(string $districtId): JsonResponse
    {
        return response()->json(
            MsVillage::query()
                ->where('DistrictID', $districtId)
                ->orderBy('Village')
                ->get([
                    'VillageID',
                    'Village',
                ])
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ORGANIZATION CASCADING
    |--------------------------------------------------------------------------
    */

    public function divisions(string $directorateId): JsonResponse
    {
        return response()->json(
            MsDivision::query()
                ->where('DirID', $directorateId)
                ->orderBy('Division')
                ->get([
                    'DivID',
                    'Division',
                ])
        );
    }

    public function departments(string $divisionId): JsonResponse
    {
        return response()->json(
            MsDepartment::query()
                ->where('DivID', $divisionId)
                ->orderBy('Department')
                ->get([
                    'DeptID',
                    'Department',
                ])
        );
    }

    public function reportTo(Request $request): JsonResponse
    {
        $directorateId = $request->string('directorateId')->toString();
        $divisionId = $request->string('divisionId')->toString();
        $departmentId = $request->string('departmentId')->toString();
        $jobTitleId = $request->integer('jobTitleId');

        if ($directorateId === '' || !$jobTitleId) {
            return response()->json([]);
        }

        /*
         * Report To is a supervisor candidate pool, not a fixed one-level
         * hierarchy.
         *
         * Rules:
         * - Staff / non-Head:
         *      may report to Head of Department, Head of Division,
         *      or Director.
         * - Head of Department:
         *      may report to Head of Division or Director.
         * - Head of Division:
         *      may report to Director.
         * - Director:
         *      no Report To.
         *
         * We deliberately do NOT force the nearest level. The user may
         * select a higher-level supervisor according to the real
         * organizational reporting line.
         */

        $jobTitle = MsJobTitle::query()
            ->where('JobTitleID', $jobTitleId)
            ->first();

        if (!$jobTitle) {
            return response()->json([]);
        }

        $selectedTitle = strtolower(trim((string) $jobTitle->JobTitle));

        $isDirector =
            str_contains($selectedTitle, 'director')
            && !str_contains($selectedTitle, 'head');

        $isHeadOfDepartment =
            str_contains($selectedTitle, 'head')
            && str_contains($selectedTitle, 'department');

        $isHeadOfDivision =
            str_contains($selectedTitle, 'head')
            && str_contains($selectedTitle, 'division');

        // Top-level position has no supervisor.
        if ($isDirector) {
            return response()->json([]);
        }

        /*
         * Candidate rules are intentionally cumulative:
         *
         * Staff:
         *   - Head of Department in the same Department
         *   - Head of Division in the same Division
         *   - Director in the same Directorate
         *
         * Head of Department:
         *   - Head of Division in the same Division
         *   - Director in the same Directorate
         *
         * Head of Division:
         *   - Director in the same Directorate
         */
        $candidates = collect();

        if (!$isHeadOfDivision && !$isHeadOfDepartment && $departmentId !== '') {
            $departmentHeads = TrEmpFormHist::query()
                ->from('Tr_EmpFormHist as hist')
                ->join('sc_user as u', 'u.EmpFormID', '=', 'hist.EmpFormID')
                ->join('ms_job_title as jt', 'jt.JobTitleID', '=', 'hist.JobTitleID')
                ->where('hist.DirID', $directorateId)
                ->where('hist.DivID', $divisionId)
                ->where('hist.DeptID', $departmentId)
                ->whereRaw("LOWER(jt.JobTitle) LIKE '%head%'")
                ->whereRaw("LOWER(jt.JobTitle) LIKE '%department%'")
                ->where('u.IsActive', true)
                ->whereNull('u.DeletedDate')
                ->select([
                    'u.UserID',
                    'u.FullName',
                    'jt.JobTitle',
                ])
                ->distinct()
                ->get();

            $candidates = $candidates->merge($departmentHeads);
        }

        if (!$isHeadOfDivision && $divisionId !== '') {
            $divisionHeads = TrEmpFormHist::query()
                ->from('Tr_EmpFormHist as hist')
                ->join('sc_user as u', 'u.EmpFormID', '=', 'hist.EmpFormID')
                ->join('ms_job_title as jt', 'jt.JobTitleID', '=', 'hist.JobTitleID')
                ->where('hist.DirID', $directorateId)
                ->where('hist.DivID', $divisionId)
                ->whereRaw("LOWER(jt.JobTitle) LIKE '%head%'")
                ->whereRaw("LOWER(jt.JobTitle) LIKE '%division%'")
                ->where('u.IsActive', true)
                ->whereNull('u.DeletedDate')
                ->select([
                    'u.UserID',
                    'u.FullName',
                    'jt.JobTitle',
                ])
                ->distinct()
                ->get();

            $candidates = $candidates->merge($divisionHeads);
        }

        // Every non-Director role may report directly to a Director.
        $directors = TrEmpFormHist::query()
            ->from('Tr_EmpFormHist as hist')
            ->join('sc_user as u', 'u.EmpFormID', '=', 'hist.EmpFormID')
            ->join('ms_job_title as jt', 'jt.JobTitleID', '=', 'hist.JobTitleID')
            ->where('hist.DirID', $directorateId)
            ->whereRaw("LOWER(jt.JobTitle) LIKE '%director%'")
            ->whereRaw("LOWER(jt.JobTitle) NOT LIKE '%head%'")
            ->where('u.IsActive', true)
            ->whereNull('u.DeletedDate')
            ->select([
                'u.UserID',
                'u.FullName',
                'jt.JobTitle',
            ])
            ->distinct()
            ->get();

        $candidates = $candidates->merge($directors);

        /*
         * Deduplicate by UserID and keep the organizational order:
         * Department Head -> Division Head -> Director.
         */
        $result = $candidates
            ->unique('UserID')
            ->values();

        return response()->json($result);
    }
}
