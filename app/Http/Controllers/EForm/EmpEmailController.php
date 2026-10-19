<?php

namespace App\Http\Controllers\EForm;

use App\Http\Controllers\Controller;
use App\Http\Requests\EForm\StoreEmpEmailRequest;
use App\Http\Requests\EForm\UpdateEmpEmailRequest;
use App\Models\EForm\TrEmpEmail;
use App\Models\Security\ScUser;
use App\Models\Workflow\WfInstance;
use App\Services\EForm\EmpEmailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $query = TrEmpEmail::query()
            ->leftJoin('sc_user as u', 'u.EmpFormID', '=', 'Tr_EmpEmail.EmpFormID')
            ->addSelect(['Tr_EmpEmail.*', 'u.Username as ReqUser']);

        // SEARCH EVERYTHING
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $keyword = '%' . $search . '%';

                $q->where('EmpEmailID', 'like', $keyword)
                    ->orWhere('Tr_EmpEmail.EmpFormID', 'like', $keyword)
                    ->orWhere('u.Username', 'like', $keyword)
                    ->orWhere('ReqType', 'like', $keyword)
                    ->orWhere('EmailType', 'like', $keyword)
                    ->orWhere('Email', 'like', $keyword)
                    ->orWhere('Purpose', 'like', $keyword)
                    ->orWhere('Notes', 'like', $keyword)
                    ->orWhere('Status', 'like', $keyword)
                    ->orWhere('CocID', 'like', $keyword)
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

        $empFormId = auth()->user()?->EmpFormId;

        $employeeEmails = $query
            ->when($empFormId !== null, function ($q) use ($empFormId) {
                $q->orderByRaw(
                    "CASE WHEN Status = 'DRAFT' AND EmpFormID = ? THEN 1 " .
                    "WHEN Status = 'WAITING_APPROVAL' THEN 2 " .
                    "WHEN Status IN ('APPROVED', 'COMPLETED') THEN 3 " .
                    "WHEN Status IN ('REJECTED', 'CANCELLED') THEN 4 " .
                    "ELSE 5 END",
                    [$empFormId]
                );
            })
            ->orderByDesc('InputDate')
            ->orderByDesc('EmpEmailID')
            ->paginate(10)
            ->withQueryString();

        $transactionIds = $employeeEmails
            ->getCollection()
            ->pluck('EmpEmailID')
            ->all();

        /*
         * Workflow aktif untuk kebutuhan tombol Cancel.
         * Jangan ubah menjadi seluruh workflow karena tombol Cancel
         * hanya membutuhkan transaksi yang masih menunggu approval.
         */
        $workflowInstances = WfInstance::query()
    ->with('steps')
    ->where('Module', 'EMPLOYEE_EMAIL')
    ->where('Status', 'WAITING_APPROVAL')
    ->whereIn(
        'TransactionID',
        $employeeEmails->getCollection()->pluck('EmpEmailID')->all()
    )
    ->orderByDesc('StartedAt')
    ->orderByDesc('InputDate')
    ->get()
    ->unique('TransactionID')
    ->keyBy('TransactionID');

        /*
         * Ambil seluruh workflow agar timeline tetap bisa menampilkan
         * transaksi yang sudah selesai maupun yang sedang berjalan.
         *
         * Satu transaksi bisa mempunyai lebih dari satu workflow.
         * Karena itu, kelompokkan berdasarkan TransactionID dan pilih
         * workflow terbaru, bukan langsung keyBy() semua hasil.
         */
        $detailWorkflowInstances = WfInstance::query()
            ->with(['steps.approver'])
            ->where('Module', 'EMPLOYEE_EMAIL')
            ->whereIn('TransactionID', $transactionIds)
            ->orderBy('StartedAt')
            ->orderBy('InputDate')
            ->get()
            ->groupBy('TransactionID')
            ->map(function ($instances) {
                return $instances->last();
            });

        $employeeEmailDetails = $employeeEmails
            ->getCollection()
            ->mapWithKeys(function ($email) use ($detailWorkflowInstances) {
                $workflow = $detailWorkflowInstances->get(
                    $email->EmpEmailID
                );

                $timeline = [];

                if ($workflow) {
                    $timeline = $workflow->steps
                        ->sortBy(function ($step) {
                            return sprintf(
                                '%010d-%010d',
                                (int) $step->RevisionNo,
                                (int) $step->StepNo
                            );
                        })
                        ->values()
                        ->map(function ($step) {
                            return [
                                'revision' => $step->RevisionNo,
                                'stepNo' => $step->StepNo,
                                'stepName' => $step->StepName,
                                'approver' => $step->approver?->Username
                                    ?? (
                                        $step->ApproverUserID
                                            ? 'User ' . $step->ApproverUserID
                                            : 'Approver belum ditemukan'
                                    ),
                                'status' => $step->Status,
                                'comments' => $step->Comments,
                                'completedAt' => $step->CompletedAt
                                    ? $step->CompletedAt->format('d M Y H:i')
                                    : null,
                                'isSkipped' => (bool) $step->IsSkipped,
                                'skipReason' => $step->SkipReason,
                            ];
                        })
                        ->all();
                }

                return [
                    $email->EmpEmailID => [
                        'givenDate' => $email->GivenDate
                            ? \Carbon\Carbon::parse(
                                $email->GivenDate
                            )->format('d M Y')
                            : '-',

                        'givenNote' => $email->GivenNote ?: '-',

                        'takeOutDate' => $email->TakeOutDate
                            ? \Carbon\Carbon::parse(
                                $email->TakeOutDate
                            )->format('d M Y')
                            : '-',

                        'takeOutNote' => $email->TakeOutNote ?: '-',

                        'timeline' => $timeline,
                    ],
                ];
            })
            ->all();

        return view(
            'eform.employee-email.index',
            compact(
                'employeeEmails',
                'search',
                'workflowInstances',
                'employeeEmailDetails'
            )
        );
    }

    public function create(): View
    {
        $empForm = $this->empEmailService
            ->currentEmployeeForm();

        $emailGroups = $this->empEmailService
            ->getCorporateEmailGroups();

        return view(
            'eform.employee-email.create',
            compact('empForm', 'emailGroups')
        );
    }

    public function store(
        StoreEmpEmailRequest $request
    ): RedirectResponse {
        try {
            $user = Auth::user();

            if (! $user instanceof ScUser) {
                abort(403, 'User login tidak valid.');
            }

            $this->empEmailService->createStandalone(
                $request->validated(),
                $user
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
                ->with('error', $e->getMessage());
        }
    }

    public function edit(string $employeeEmail): View
    {
        $email = $this->empEmailService
            ->find($employeeEmail);

        $corporateEmailGroups = $this->empEmailService
            ->getCorporateEmailGroups();

        return view(
            'eform.employee-email.edit',
            compact('email', 'corporateEmailGroups')
        );
    }

    public function update(
        UpdateEmpEmailRequest $request,
        string $employeeEmail
    ): RedirectResponse {
        try {
            $user = Auth::user();

            if (! $user instanceof ScUser) {
                abort(403, 'User login tidak valid.');
            }

            $this->empEmailService->updateStandalone(
                $employeeEmail,
                $request->validated(),
                $user
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
                ->with('error', $e->getMessage());
        }
    }

    public function updateFulfillment(Request $request, string $employeeEmail): RedirectResponse
    {
        $validated = $request->validate([
            'Email' => ['nullable', 'string', 'max:255'],
            'IsGiven' => ['required', 'boolean'],
            'GivenDate' => ['nullable', 'date'],
            'GivenNote' => ['nullable', 'string', 'max:1000'],
            'IsTakeOut' => ['required', 'boolean'],
            'TakeOutDate' => ['nullable', 'date'],
            'TakeOutNote' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = Auth::user();
        if (! $user instanceof ScUser) {
            abort(403, 'User login tidak valid.');
        }

        try {
            $this->empEmailService->updateFulfillment($employeeEmail, $validated, $user);
            return redirect()->route('employee-email.index')
                ->with('success', 'IT Fulfillment berhasil disimpan.');
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(
        string $employeeEmail
    ): RedirectResponse {
        try {
            $user = Auth::user();

            if (! $user instanceof ScUser) {
                abort(403, 'User login tidak valid.');
            }

            // User login dikirim agar service bisa memvalidasi kepemilikan.
            $this->empEmailService->delete(
                $employeeEmail,
                $user
            );

            return redirect()
                ->route('employee-email.index')
                ->with(
                    'success',
                    'Employee Email berhasil dihapus.'
                );
        } catch (RuntimeException $e) {
            return back()
                ->with('error', $e->getMessage());
        }
    }
}
