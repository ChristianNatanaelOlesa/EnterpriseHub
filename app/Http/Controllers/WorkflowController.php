<?php

namespace App\Http\Controllers;

use App\Enums\WorkflowStatus;
use App\Models\Workflow\WfInstance;
use App\Models\Security\ScUser;
use App\Services\Transaction\TransactionDetailRegistry;
use App\Services\Workflow\WorkflowEngine;
use App\Services\Workflow\WorkflowException;
use App\Support\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkflowController extends Controller
{
    public function __construct(
        protected WorkflowEngine $engine,
        protected TransactionDetailRegistry $transactionDetails,
    ) {
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        $approvals = WfInstance::query()
            ->with(['process', 'requester', 'steps' => fn ($q) => $q->where('Status', 'ACTIVE')])
            ->where('Status', WorkflowStatus::WAITING_APPROVAL->value)
            ->whereHas('steps', function ($q) {
                $q->where('Status', 'ACTIVE')
                    ->where('ApproverUserID', (int) auth()->user()->UserID);
            })
            ->when($search !== '', function ($q) use ($search) {
                $like = '%' . $search . '%';
                $q->where(function ($x) use ($like) {
                    $x->where('WorkflowInstanceID', 'like', $like)
                        ->orWhere('Module', 'like', $like)
                        ->orWhere('TransactionID', 'like', $like)
                        ->orWhereHas('process', fn ($p) => $p->where('Process', 'like', $like))
                        ->orWhereHas('requester', fn ($u) => $u->where('Username', 'like', $like));
                });
            })
            ->orderByDesc('StartedAt')
            ->paginate(10)
            ->withQueryString();

        return view('workflow.index', compact('approvals', 'search'));
    }

    public function show(string $instance): View
    {
        $workflow = WfInstance::query()
            ->with([
                'process',
                'requester',
                'steps.approver',
                'revisions.requestedBy',
                'revisions.targetUser',
            ])
            ->findOrFail($instance);

        // A user with access to the My Approval menu must not be able to
        // inspect arbitrary workflow instances by guessing their IDs.
        $userId = (int) auth()->user()->UserID;
        $isRequester = (int) $workflow->RequesterUserID === $userId;
        $isApprover = $workflow->steps->contains(
            fn ($step) => (int) $step->ApproverUserID === $userId
        );

        abort_unless($isRequester || $isApprover, 403);

        $activeStep = $workflow->steps->first(fn ($step) => $step->Status === 'ACTIVE');
        $canAct = $activeStep
            && (int) $activeStep->ApproverUserID === (int) auth()->user()->UserID
            && $workflow->Status === WorkflowStatus::WAITING_APPROVAL->value;

        $transaction = $this->loadTransaction($workflow);

        return view('workflow.show', compact('workflow', 'activeStep', 'canAct', 'transaction'));
    }

    /**
     * Read-only transaction detail for requesters and workflow participants.
     *
     * A normal requester does not need access to the My Approval menu just to
     * inspect their own submission. Approval actions remain available only via
     * workflow.show / My Approval.
     */
    public function detail(string $instance): View
    {
        $workflow = WfInstance::query()
            ->with([
                'process',
                'requester',
                'steps.approver',
                'revisions.requestedBy',
                'revisions.targetUser',
            ])
            ->findOrFail($instance);

        $userId = (int) auth()->user()->UserID;

        $isRequester = (int) $workflow->RequesterUserID === $userId;
        $isApprover = $workflow->steps->contains(
            fn ($step) => (int) $step->ApproverUserID === $userId
        );

        abort_unless($isRequester || $isApprover, 403);

        // This route is explicitly read-only. Approval remains in My Approval.
        $activeStep = $workflow->steps->first(fn ($step) => $step->Status === 'ACTIVE');
        $canAct = false;
        $transaction = $this->loadTransaction($workflow);

        return view('workflow.show', compact('workflow', 'activeStep', 'canAct', 'transaction'));
    }

    public function detailModal(string $instance): View
    {
        $workflow = WfInstance::query()
            ->with([
                'process',
                'requester',
                'steps.approver',
                'revisions.requestedBy',
                'revisions.targetUser',
            ])
            ->findOrFail($instance);

        $userId = (int) auth()->user()->UserID;

        $isRequester = (int) $workflow->RequesterUserID === $userId;
        $isApprover = $workflow->steps->contains(
            fn ($step) => (int) $step->ApproverUserID === $userId
        );

        abort_unless($isRequester || $isApprover, 403);

        $transaction = $this->loadTransaction($workflow);
        $sections = $this->transactionDetails->sectionsForWorkflow(
            $workflow->Module,
            $workflow->TransactionID
        );

        return view('workflow.partials.transaction-detail-modal', compact(
            'workflow',
            'transaction',
            'sections',
        ));
    }

    public function approve(Request $request, string $instance): RedirectResponse
    {
        try {
            $this->engine->approve(
                $instance,
                trim((string) $request->input('Comments', '')) ?: null,
                auth()->user()
            );

            return redirect()->route('workflow.show', $instance)
                ->with('success', 'Approval berhasil diproses.');
        } catch (WorkflowException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function revision(Request $request, string $instance): RedirectResponse
    {
        $data = $request->validate([
            'Comments' => ['required', 'string', 'max:2000'],
        ]);

        try {
            $this->engine->requestRevision(
                $instance,
                $data['Comments'],
                auth()->user(),
                'REQUESTER',
                null,
            );

            return redirect()->route('workflow.show', $instance)
                ->with('success', 'Request Revision berhasil dikirim ke requester.');
        } catch (WorkflowException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function reject(Request $request, string $instance): RedirectResponse
    {
        $data = $request->validate([
            'Comments' => ['required', 'string', 'max:2000'],
        ]);

        try {
            $this->engine->reject(
                $instance,
                $data['Comments'],
                auth()->user()
            );

            return redirect()->route('workflow.show', $instance)
                ->with('success', 'Transaction berhasil di-reject.');
        } catch (WorkflowException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function requestApproval(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'process_id' => ['required', 'string', 'max:100'],
            'module' => ['required', 'string', 'max:100'],
            'transaction_id' => ['required', 'string', 'max:100'],
            'target_emp_form_id' => ['nullable', 'string', 'max:100'],
        ]);

        // Normalize identifiers before resolving the provider or checking grants.
        $data['module'] = strtoupper(trim($data['module']));
        $data['process_id'] = strtoupper(trim($data['process_id']));

        // A request must not pair a valid transaction module with a different
        // workflow process. Otherwise a client could manipulate the process_id
        // and attempt to select a different approval chain.
        abort_unless(
            $data['module'] === $data['process_id'],
            403,
            'Workflow process tidak sesuai dengan module transaksi.'
        );

        // Request Approval is a write operation. The requester must have
        // Update permission for the transaction module, in addition to being
        // the owner of the underlying transaction. Do not trust the hidden
        // module field sent by the browser: resolve it through an explicit
        // allow-list and fail closed for modules not mapped here.
        $permissionRoute = match ($data['module']) {
            'EMPLOYEE_APPLICATION_EXTERNAL',
            'EMPLOYEE_APPLICATION_INTERNAL' => 'employee-app.index',
            'EMPLOYEE_EMAIL' => 'employee-email.index',
            'EMPLOYEE_EQUIPMENT' => 'employee-equipment.index',
            'EMPLOYEE_NETWORK' => 'employee-network.index',
            'EMPLOYEE_INFRA' => 'employee-infra.index',
            'EMPLOYEE_IT_AREA' => 'employee-it-area.index',
            'EMPLOYEE_SOFTWARE' => 'employee-software.index',
            'EMPLOYEE_SHARING_FOLDER' => 'employee-sharing-folder.index',
            default => null,
        };

        abort_unless(
            $permissionRoute !== null
                && Permission::can('Update', $permissionRoute),
            403,
            'You do not have permission to request approval for this transaction.'
        );

        try {
            $transaction = $this->loadTransactionByPayload($data);

            if (!$transaction) {
                throw new WorkflowException('Transaction tidak ditemukan.');
            }


            $attributes = $transaction->getAttributes();

            $currentEmpFormId = trim((string) (auth()->user()->EmpFormID ?? ''));

            if (!array_key_exists('EmpFormID', $attributes)) {
                throw new WorkflowException(
                    'Request Approval ditolak: data transaksi tidak memiliki EmpFormID requester.'
                );
            }

            $transactionRequester = trim((string) ($attributes['EmpFormID'] ?? ''));

            if ($currentEmpFormId === '' || $transactionRequester === '') {
                throw new WorkflowException(
                    'Request Approval ditolak: informasi requester tidak valid.'
                );
            }

            if ($transactionRequester !== $currentEmpFormId) {
                throw new WorkflowException(
                    'Hanya requester yang dapat melakukan Request Approval.'
                );
            }


            $this->engine->requestApproval(
                $data['process_id'],
                $data['module'],
                $data['transaction_id'],
                auth()->user(),
                auth()->user()->EmpFormID,
                $data['target_emp_form_id'] ?? null,
                $transaction,
                'Status',
            );

            return redirect()->back()->with(
                'success',
                'Pengajuan berhasil dikirim dan menunggu proses approval.'
            );
        } catch (WorkflowException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    protected function loadTransaction(WfInstance $workflow): mixed
    {
        return $this->transactionDetails->resolveForWorkflow(
            (string) $workflow->Module,
            (string) $workflow->TransactionID
        );
    }

    protected function loadTransactionByPayload(array $data): mixed
    {
        return $this->transactionDetails->resolve(
            (string) $data['module'],
            (string) $data['transaction_id'],
        );
    }

    public function cancel(string $instance): RedirectResponse
    {
        abort_unless(
            Permission::can('Update', 'employee-email.index'),
            403,
            'You do not have permission to cancel this Employee Email request.'
        );

        $user = auth()->user();

        if (!$user instanceof \App\Models\Security\ScUser) {
            abort(403, 'User login tidak valid.');
        }

        try {
            $this->engine->cancelByRequester($instance, $user);

            return redirect()->back()->with(
                'success',
                'Pengajuan Employee Email berhasil dibatalkan.'
            );
        } catch (WorkflowException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
