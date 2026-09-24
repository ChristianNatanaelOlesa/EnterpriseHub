<?php

namespace App\Http\Controllers\EForm;

use App\Http\Controllers\Controller;
use App\Models\EForm\TrEmpEmail;
use App\Http\Requests\EForm\StoreEmpEmailRequest;
use App\Http\Requests\EForm\UpdateEmpEmailRequest;
use App\Services\EForm\EmpEmailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class EmpEmailController extends Controller
{
    public function __construct(
        protected EmpEmailService $empEmailService
    ) {
    }

    public function index(Request $request): View
    {
        $search = trim(
            (string) $request->input('search', '')
        );

        $query = TrEmpEmail::query();


        // =========================================================
        // SEARCH EVERYTHING
        // =========================================================

        if ($search !== '') {

            $query->where(function ($q) use ($search) {

                $keyword = '%' . $search . '%';

                $q->where(
                    'EmpEmailID',
                    'like',
                    $keyword
                )

                ->orWhere(
                    'EmpFormID',
                    'like',
                    $keyword
                )

                ->orWhere(
                    'ReqDivID',
                    'like',
                    $keyword
                )

                ->orWhere(
                    'ReqUser',
                    'like',
                    $keyword
                )

                ->orWhere(
                    'ReqType',
                    'like',
                    $keyword
                )

                ->orWhere(
                    'EmailType',
                    'like',
                    $keyword
                )

                ->orWhere(
                    'Email',
                    'like',
                    $keyword
                )

                ->orWhere(
                    'Purpose',
                    'like',
                    $keyword
                )

                ->orWhere(
                    'Notes',
                    'like',
                    $keyword
                )

                ->orWhere(
                    'Status',
                    'like',
                    $keyword
                )

                ->orWhere(
                    'CocID',
                    'like',
                    $keyword
                )

                ->orWhereRaw(
                    "DATE_FORMAT(ReqDate, '%Y-%m-%d') LIKE ?",
                    [$keyword]
                )

                ->orWhereRaw(
                    "DATE_FORMAT(DateFrom, '%Y-%m-%d') LIKE ?",
                    [$keyword]
                )

                ->orWhereRaw(
                    "DATE_FORMAT(DateUntil, '%Y-%m-%d') LIKE ?",
                    [$keyword]
                );

            });

        }


        // =========================================================
        // ORDER
        // =========================================================

        $employeeEmails = $query
            ->orderByDesc('InputDate')
            ->orderByDesc('EmpEmailID')
            ->paginate(10)
            ->withQueryString();


        return view(
            'eform.employee-email.index',
            compact(
                'employeeEmails',
                'search'
            )
        );
    }

    public function create(): View
    {
        $empForm = $this->empEmailService->currentEmployeeForm();

        $emailGroups = $this->empEmailService->getCorporateEmailGroups();

        return view(
            'eform.employee-email.create',
            compact(
                'empForm',
                'emailGroups'
            )
        );
    }

    public function store(
        StoreEmpEmailRequest $request
    ): RedirectResponse {
        try {

            $this->empEmailService->createStandalone(
                $request->validated(),
                auth()->user()
            );

            return redirect()
                ->route('employee-email.index')
                ->with(
                    'success',
                    'Employee Email berhasil dibuat.'
                );

        } catch (RuntimeException $e) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    public function edit(string $employeeEmail): View
    {
        $email = $this->empEmailService->find(
            $employeeEmail
        );

        $corporateEmailGroups =
            $this->empEmailService->getCorporateEmailGroups();

        return view(
            'eform.employee-email.edit',
            compact(
                'email',
                'corporateEmailGroups'
            )
        );
    }

    public function update(
        UpdateEmpEmailRequest $request,
        string $employeeEmail
    ): RedirectResponse {
        try {

            $this->empEmailService->updateStandalone(
                $employeeEmail,
                $request->validated(),
                auth()->user()
            );

            return redirect()
                ->route('employee-email.index')
                ->with(
                    'success',
                    'Employee Email berhasil diupdate.'
                );

        } catch (RuntimeException $e) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    public function destroy(
        string $employeeEmail
    ): RedirectResponse {
        try {

            $this->empEmailService->delete(
                $employeeEmail
            );

            return redirect()
                ->route('employee-email.index')
                ->with(
                    'success',
                    'Employee Email berhasil dihapus.'
                );

        } catch (RuntimeException $e) {

            return back()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }
}
