<?php

namespace Tests\Feature;

use App\Models\Security\ScMenu;
use App\Models\Security\ScMenuPermission;
use App\Models\Security\ScPermission;
use App\Models\Security\ScRole;
use App\Models\Security\ScRolePermission;
use App\Models\Security\ScUser;
use App\Models\Security\ScUserRole;
use App\Repositories\Security\UserRoleRepository;
use App\Services\Security\PermissionService;
use App\Support\Permission;
use Database\Seeders\Security\RolePermissionSeeder;
use Database\Seeders\Security\MenuPermissionSeeder;
use Database\Seeders\Security\NormalizedSecuritySeeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SecurityPermissionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('sc_user', function (Blueprint $table): void {
            $table->bigIncrements('UserID'); $table->string('EmpFormID', 13)->nullable()->unique();
            $table->string('Username')->unique(); $table->string('FullName')->nullable(); $table->string('Password')->nullable();
            $table->string('Email')->nullable()->unique(); $table->string('PhoneNumber')->nullable();
            $table->boolean('IsActive')->default(true); $table->timestamp('DeletedDate')->nullable(); $this->auditColumns($table);
        });
        Schema::create('sc_role', function (Blueprint $table): void {
            $table->string('RoleID', 5)->primary(); $table->string('Role'); $table->string('Description')->nullable();
            $table->boolean('IsActive')->default(true); $table->timestamp('DeletedDate')->nullable(); $this->auditColumns($table);
        });
        Schema::create('sc_user_role', function (Blueprint $table): void {
            $table->bigIncrements('UserRoleID'); $table->unsignedBigInteger('UserID'); $table->string('RoleID', 5);
            $table->boolean('IsActive')->default(true); $table->timestamp('DeletedDate')->nullable(); $this->auditColumns($table);
        });
        Schema::create('sc_menu', function (Blueprint $table): void {
            $table->string('MenuID', 8)->primary(); $table->string('Menu'); $table->string('Description')->nullable();
            $table->string('ParentID', 8)->nullable();
            $table->string('Route')->nullable(); $table->string('URL')->nullable(); $table->string('Icon')->nullable();
            $table->string('MenuArea')->default('TOP'); $table->unsignedTinyInteger('Lvl')->default(1);
            $table->boolean('IsMenu')->default(true); $table->boolean('IsActive')->default(true); $table->integer('SortOrder')->default(0);
            $table->timestamp('DeletedDate')->nullable(); $this->auditColumns($table);
        });
        Schema::create('sc_permission', function (Blueprint $table): void {
            $table->bigIncrements('PermissionID'); $table->string('Name')->unique();
            $table->boolean('IsActive')->default(true); $table->timestamp('DeletedDate')->nullable(); $this->auditColumns($table);
        });
        Schema::create('sc_menu_permission', function (Blueprint $table): void {
            $table->bigIncrements('MenuPermissionID'); $table->string('MenuID', 8); $table->unsignedBigInteger('PermissionID');
            $table->boolean('IsActive')->default(true); $table->timestamp('DeletedDate')->nullable(); $this->auditColumns($table);
            $table->unique(['MenuID', 'PermissionID']);
        });
        Schema::create('sc_role_permission', function (Blueprint $table): void {
            $table->bigIncrements('RolePermissionID'); $table->string('RoleID', 5); $table->unsignedBigInteger('MenuPermissionID');
            $table->boolean('IsActive')->default(true); $table->timestamp('DeletedDate')->nullable(); $this->auditColumns($table);
            $table->unique(['RoleID', 'MenuPermissionID']);
        });
        Schema::create('sc_security_id_sequence', function (Blueprint $table): void {
            $table->string('Entity', 10); $table->string('Scope', 16); $table->unsignedSmallInteger('NextValue')->default(0);
            $table->primary(['Entity', 'Scope']);
        });
        Schema::create('tr_empform', function (Blueprint $table): void {
            $table->string('EmpFormID', 13)->primary(); $table->string('FirstName'); $table->string('LastName');
            $table->string('MobileNo')->nullable(); $table->string('Email')->nullable();
        });
        Schema::create('wf_instance', function (Blueprint $table): void {
            $table->uuid('WorkflowInstanceID')->primary(); $table->string('Status');
        });
        Schema::create('wf_instance_step', function (Blueprint $table): void {
            $table->bigIncrements('WorkflowInstanceStepID'); $table->uuid('WorkflowInstanceID');
            $table->string('Status'); $table->unsignedBigInteger('ApproverUserID')->nullable();
        });
    }

    public function test_menu_is_hidden_until_view_is_granted_and_navigation_does_not_grant_actions(): void
    {
        [$user, $role, $menu, $view] = $this->fixture();
        $this->assignRole($user, $role);
        Auth::login($user);
        $this->assertFalse(Permission::can('View', $menu->Route));
        $this->assertFalse(Permission::can('Create', $menu->Route));
        $this->assertFalse(Permission::topMenuTree()->flatten(1)->contains('MenuID', $menu->MenuID));

        $viewLink = ScMenuPermission::query()->create([
            'MenuID' => $menu->MenuID, 'PermissionID' => $view->PermissionID, 'IsActive' => true,
            'InputUser' => 'Security seeder', 'ModifUser' => 'Security seeder',
        ]);
        $this->grant($role, $viewLink);
        $this->assertTrue(Permission::can('View', $menu->Route));
        $this->assertTrue(Permission::topMenuTree()->flatten(1)->contains('MenuID', $menu->MenuID));
        $this->assertFalse(Permission::can('Create', $menu->Route));
    }

    public function test_dynamic_master_permission_can_be_granted_and_ungranted_backend_action_is_denied(): void
    {
        [$user, $role, $menu] = $this->fixture();
        $this->assignRole($user, $role);
        Auth::login($user);

        $cancel = ScPermission::query()->create(['Name' => 'Cancel', 'IsActive' => true]);
        $cancelLink = ScMenuPermission::query()->create(['MenuID' => $menu->MenuID, 'PermissionID' => $cancel->PermissionID, 'IsActive' => true]);
        $reopen = ScPermission::query()->create(['Name' => 'Reopen', 'IsActive' => true]);
        ScMenuPermission::query()->create(['MenuID' => $menu->MenuID, 'PermissionID' => $reopen->PermissionID, 'IsActive' => true]);

        Route::middleware('permission:security.test.index,Cancel')->get('/_test/security/cancel', fn () => 'allowed');
        Route::middleware('permission:security.test.index,Reopen')->get('/_test/security/reopen', fn () => 'allowed');
        $this->grant($role, $cancelLink);

        $this->getJson('/_test/security/cancel')->assertOk()->assertSeeText('allowed');
        $this->getJson('/_test/security/reopen')->assertForbidden();
        $this->assertFalse(Schema::hasTable('sc_role_menu'));
        $this->assertFalse(Schema::hasTable('sc_page_permission'));
    }

    public function test_inactive_role_assignment_does_not_grant_backend_permission(): void
    {
        [$user, $role, $menu, $view] = $this->fixture();
        $link = ScMenuPermission::query()->create(['MenuID' => $menu->MenuID, 'PermissionID' => $view->PermissionID, 'IsActive' => true]);
        $this->grant($role, $link);
        ScUserRole::query()->create(['UserID' => $user->UserID, 'RoleID' => $role->RoleID, 'IsActive' => false]);
        Auth::login($user);
        $this->assertFalse(Permission::can('View', $menu->Route));
    }

    public function test_dynamic_permission_master_is_registered_for_menu_and_can_be_deactivated_without_deleting_links(): void
    {
        [$user, , $menu] = $this->fixture();
        Auth::login($user);
        $menu->update(['Route' => 'dashboard']);
        $this->assertTrue(Route::has($menu->Route));

        $service = app(PermissionService::class);
        $permission = $service->store(['Name' => 'Import', 'IsActive' => true]);
        $this->assertDatabaseMissing('sc_menu_permission', [
            'MenuID' => $menu->MenuID,
            'PermissionID' => $permission->PermissionID,
        ]);

        $menuPermission = ScMenuPermission::query()->create([
            'MenuID' => $menu->MenuID,
            'PermissionID' => $permission->PermissionID,
            'IsActive' => true,
        ]);

        $this->assertTrue($menuPermission->IsActive);

        $service->deactivate((int) $permission->PermissionID);

        $this->assertFalse($permission->fresh()->IsActive);
        $this->assertDatabaseHas('sc_menu_permission', [
            'MenuPermissionID' => $menuPermission->MenuPermissionID,
            'IsActive' => true,
        ]);
    }

    public function test_new_menu_mapping_is_available_but_not_granted_until_role_is_explicitly_updated(): void
    {
        [$user, $role, $menu] = $this->fixture();
        $menu->update(['Route' => 'security.menus.index']);
        $this->assignRole($user, $role);
        $approve = ScPermission::query()->create(['Name' => 'Approve', 'IsActive' => true]);
        $update = ScPermission::query()->create(['Name' => 'Update', 'IsActive' => true]);
        $view = ScPermission::query()->firstOrCreate(['Name' => 'View'], ['Name' => 'View', 'IsActive' => true]);
        $viewMapping = ScMenuPermission::query()->create(['MenuID' => $menu->MenuID, 'PermissionID' => $view->PermissionID, 'IsActive' => true]);
        $this->grant($role, $viewMapping);
        $updateMapping = ScMenuPermission::query()->create(['MenuID' => $menu->MenuID, 'PermissionID' => $update->PermissionID, 'IsActive' => true]);
        $this->grant($role, $updateMapping);

        $this->actingAs($user)->put(route('security.menus.update', $menu->MenuID), [
            'ParentID' => null, 'Menu' => 'Menus', 'Description' => 'Menus', 'MenuArea' => 'TOP', 'Route' => 'security.menus.index',
            'URL' => null, 'Icon' => null, 'SortOrder' => 1, 'IsMenu' => '1', 'IsActive' => '1',
            'permission_configuration_submitted' => '1',
            'permission_ids' => [$view->PermissionID, $update->PermissionID, $approve->PermissionID],
        ])->assertRedirect(route('security.menus.index'));

        $approveMapping = ScMenuPermission::query()->where('MenuID', $menu->MenuID)
            ->where('PermissionID', $approve->PermissionID)->firstOrFail();
        $this->assertDatabaseMissing('sc_role_permission', [
            'RoleID' => $role->RoleID, 'MenuPermissionID' => $approveMapping->MenuPermissionID,
        ]);

        $roleMenu = ScMenu::query()->create([
            'MenuID' => '02-00-00', 'Menu' => 'Role Management',
            'Route' => 'security.roles.index', 'IsMenu' => true, 'IsActive' => true,
        ]);
        $roleMenuMappingIds = [];
        foreach ([$view, $update] as $rolePermission) {
            $mapping = ScMenuPermission::query()->create([
                'MenuID' => $roleMenu->MenuID, 'PermissionID' => $rolePermission->PermissionID, 'IsActive' => true,
            ]);
            $this->grant($role, $mapping);
            $roleMenuMappingIds[] = $mapping->MenuPermissionID;
        }
        $roleEdit = $this->get(route('security.roles.edit', $role->RoleID));
        $roleEdit->assertOk()->assertSeeText('Approve');
        $this->assertMatchesRegularExpression(
            '/<input[^>]*value="' . $approveMapping->MenuPermissionID . '"[^>]*>/',
            $roleEdit->getContent(),
        );
        $this->assertDoesNotMatchRegularExpression(
            '/<input[^>]*value="' . $approveMapping->MenuPermissionID . '"[^>]*checked/',
            $roleEdit->getContent(),
        );
        $this->assertFalse(app(\App\Repositories\Security\RoleRepository::class)
            ->getRolePermissions($role->RoleID)->has($approveMapping->MenuPermissionID));

        $this->put(route('security.roles.update', $role->RoleID), [
            'Role' => $role->Role, 'Name' => $role->Role, 'Description' => 'Tester', 'IsActive' => '1',
            'menu_permissions' => [$viewMapping->MenuPermissionID, $updateMapping->MenuPermissionID,
                ...$roleMenuMappingIds, $approveMapping->MenuPermissionID],
        ])->assertRedirect(route('security.roles.index'));
        $this->assertDatabaseHas('sc_role_permission', [
            'RoleID' => $role->RoleID, 'MenuPermissionID' => $approveMapping->MenuPermissionID, 'IsActive' => true,
        ]);
        $this->assertTrue(app(\App\Repositories\Security\RoleRepository::class)
            ->getRolePermissions($role->RoleID)->has($approveMapping->MenuPermissionID));

        $cancel = ScPermission::query()->create(['Name' => 'Cancel', 'IsActive' => true]);
        $inactiveMapping = ScMenuPermission::query()->create([
            'MenuID' => $roleMenu->MenuID, 'PermissionID' => $cancel->PermissionID,
            'IsActive' => false, 'DeletedDate' => now(),
        ]);
        $this->put(route('security.roles.update', $role->RoleID), [
            'Role' => $role->Role, 'Name' => $role->Role, 'Description' => '', 'IsActive' => '1',
            'menu_permissions' => [$inactiveMapping->MenuPermissionID],
        ])->assertSessionHasErrors('menu_permissions');
        $this->assertDatabaseMissing('sc_role_permission', [
            'RoleID' => $role->RoleID, 'MenuPermissionID' => $inactiveMapping->MenuPermissionID,
        ]);

    }

    public function test_permission_management_routes_support_crud_with_backend_authorization(): void
    {
        [$user, $role, $menu, $view] = $this->fixture();
        $menu->update(['Route' => 'security.permissions.index']);
        $this->assignRole($user, $role);

        foreach ([$view, ...[
            ScPermission::query()->create(['Name' => 'Create', 'IsActive' => true]),
            ScPermission::query()->create(['Name' => 'Update', 'IsActive' => true]),
            ScPermission::query()->create(['Name' => 'Delete', 'IsActive' => true]),
        ]] as $permission) {
            $link = ScMenuPermission::query()->create([
                'MenuID' => $menu->MenuID,
                'PermissionID' => $permission->PermissionID,
                'IsActive' => true,
            ]);
            $this->grant($role, $link);
        }

        $this->actingAs($user)
            ->get(route('security.permissions.index'))
            ->assertOk()
            ->assertSeeText('Permission Management');

        $this->post(route('security.permissions.store'), [
            'Name' => 'Import', 'IsActive' => '1',
        ])->assertRedirect(route('security.permissions.index'));

        $permission = ScPermission::query()->where('Name', 'Import')->firstOrFail();
        $this->get(route('security.permissions.edit', $permission->PermissionID))->assertOk();
        $this->put(route('security.permissions.update', $permission->PermissionID), [
            'Name' => 'Import Data', 'IsActive' => '1',
        ])->assertRedirect(route('security.permissions.index'));
        $this->assertDatabaseHas('sc_permission', [
            'PermissionID' => $permission->PermissionID, 'Name' => 'Import Data', 'IsActive' => true,
        ]);

        $this->delete(route('security.permissions.destroy', $permission->PermissionID))
            ->assertRedirect(route('security.permissions.index'));
        $this->assertDatabaseHas('sc_permission', [
            'PermissionID' => $permission->PermissionID, 'IsActive' => false,
        ]);
    }

    public function test_user_access_routes_manage_accounts_and_multiple_role_assignments(): void
    {
        [$admin, $role, $menu] = $this->fixture();
        $this->grantRoutePermissions($admin, $role, $menu, 'SECURITY_USERS', 'security.users.index', ['View', 'Create', 'Update', 'Delete']);
        $secondRole = ScRole::query()->create([
            'RoleID' => 'RL002', 'Role' => 'Second role', 'IsActive' => true,
        ]);
        \Illuminate\Support\Facades\DB::table('tr_empform')->insert([
            'EmpFormID' => 'EMP000000001', 'FirstName' => 'New', 'LastName' => 'Account',
            'MobileNo' => '08123456789', 'Email' => 'new.account@example.test',
        ]);

        $this->actingAs($admin)->post(route('security.users.store'), [
            'EmpFormID' => 'EMP000000001', 'Username' => 'new.account', 'FullName' => 'New Account',
            'Email' => 'new.account@example.test', 'PhoneNumber' => '08123456789', 'IsActive' => '1',
            'RoleIDs' => [$role->RoleID, $secondRole->RoleID],
        ])->assertRedirect(route('security.users.index'));

        $newUser = ScUser::query()->where('Username', 'new.account')->firstOrFail();
        $this->assertSame(2, ScUserRole::query()->where('UserID', $newUser->UserID)->where('IsActive', true)->count());
        $this->get(route('security.users.edit', $newUser->UserID))->assertOk();

        $this->put(route('security.users.update', $newUser->UserID), [
            'Username' => 'new.account', 'FullName' => 'Updated Account',
            'Email' => 'new.account@example.test', 'PhoneNumber' => '08123456789', 'IsActive' => '1',
            'RoleIDs' => [$secondRole->RoleID],
        ])->assertRedirect(route('security.users.index'));
        $this->assertSame([$secondRole->RoleID], app(UserRoleRepository::class)->getUserRoleIds((int) $newUser->UserID));

        $this->delete(route('security.users.destroy', $newUser->UserID))->assertRedirect(route('security.users.index'));
        $this->assertDatabaseHas('sc_user', ['UserID' => $newUser->UserID, 'IsActive' => false]);
    }

    public function test_role_management_routes_persist_only_selected_valid_menu_permissions(): void
    {
        [$admin, $role, $menu] = $this->fixture();
        $links = $this->grantRoutePermissions($admin, $role, $menu, 'SECURITY_ROLES', 'security.roles.index', ['View', 'Create', 'Update', 'Delete']);

        $this->actingAs($admin)->get(route('security.roles.index'))->assertOk();
        $this->post(route('security.roles.store'), [
            'Role' => 'Auditor', 'Name' => 'Auditor', 'Description' => 'Read only', 'IsActive' => '1',
            'menu_permissions' => [$links['View']->MenuPermissionID],
        ])->assertRedirect(route('security.roles.index'));

        $createdRole = ScRole::query()->where('Role', 'Auditor')->firstOrFail();
        $this->assertDatabaseHas('sc_role_permission', [
            'RoleID' => $createdRole->RoleID,
            'MenuPermissionID' => $links['View']->MenuPermissionID,
            'IsActive' => true,
        ]);
        $this->get(route('security.roles.edit', $createdRole->RoleID))->assertOk();

        $this->put(route('security.roles.update', $createdRole->RoleID), [
            'Role' => 'Updated Auditor', 'Name' => 'Updated Auditor', 'Description' => 'Updated', 'IsActive' => '1',
            'menu_permissions' => [],
        ])->assertRedirect(route('security.roles.index'));
        $this->assertDatabaseHas('sc_role_permission', [
            'RoleID' => $createdRole->RoleID,
            'MenuPermissionID' => $links['View']->MenuPermissionID,
            'IsActive' => false,
        ]);

        $this->delete(route('security.roles.destroy', $createdRole->RoleID))->assertRedirect(route('security.roles.index'));
        $this->assertDatabaseHas('sc_role', ['RoleID' => $createdRole->RoleID, 'IsActive' => false]);
    }

    public function test_menu_management_routes_create_update_and_deactivate_without_cascade(): void
    {
        [$admin, $role, $menu] = $this->fixture();
        $this->grantRoutePermissions($admin, $role, $menu, 'SECURITY_MENUS', 'security.menus.index', ['View', 'Create', 'Update', 'Delete']);

        $this->actingAs($admin)->get(route('security.menus.index'))->assertOk();
        $this->post(route('security.menus.store'), [
            'ParentID' => null, 'Menu' => 'Audit Menu', 'Description' => 'Audit Menu', 'MenuArea' => 'TOP', 'Route' => 'dashboard',
            'URL' => null, 'Icon' => 'bi bi-list', 'SortOrder' => 50, 'IsMenu' => '1', 'IsActive' => '1',
        ])->assertRedirect(route('security.menus.index'));

        $createdMenu = ScMenu::query()->where('Menu', 'Audit Menu')->firstOrFail();
        $this->assertSame('02-00-00', $createdMenu->MenuID);
        $this->assertSame(1, (int) $createdMenu->Lvl);
        $this->get(route('security.menus.edit', $createdMenu->MenuID))->assertOk();

        $this->put(route('security.menus.update', $createdMenu->MenuID), [
            'ParentID' => null, 'Menu' => 'Updated Audit Menu', 'Description' => 'Updated Audit Menu', 'MenuArea' => 'TOP', 'Route' => 'dashboard',
            'URL' => null, 'Icon' => 'bi bi-list', 'SortOrder' => 51, 'IsMenu' => '1', 'IsActive' => '1',
        ])->assertRedirect(route('security.menus.index'));
        $this->assertDatabaseHas('sc_menu', ['MenuID' => $createdMenu->MenuID, 'Menu' => 'Updated Audit Menu']);

        $this->delete(route('security.menus.destroy', $createdMenu->MenuID))->assertRedirect(route('security.menus.index'));
        $this->assertDatabaseHas('sc_menu', ['MenuID' => $createdMenu->MenuID, 'IsActive' => false]);
    }

    public function test_user_can_have_multiple_roles_and_duplicate_role_ids_are_synced_once(): void
    {
        [$user, $firstRole] = $this->fixture();
        $secondRole = ScRole::query()->create([
            'RoleID' => 'RL002', 'Role' => 'Second role', 'IsActive' => true,
        ]);
        $repository = app(UserRoleRepository::class);

        $repository->sync((int) $user->UserID, [$firstRole->RoleID, $secondRole->RoleID, $firstRole->RoleID], 'tester');

        $this->assertSame(2, ScUserRole::query()->where('UserID', $user->UserID)->where('IsActive', true)->count());
        $repository->sync((int) $user->UserID, [$secondRole->RoleID], 'tester');
        $this->assertSame([$secondRole->RoleID], $repository->getUserRoleIds((int) $user->UserID));
    }

    public function test_role_permission_seeder_does_not_grant_new_actions_or_reactivate_admin_revocations(): void
    {
        [$user, $role, $menu, $view] = $this->fixture();
        $role->update(['Role' => 'Super Administrator']);
        $menu->update(['Route' => 'security.users.index']);
        $import = ScPermission::query()->create(['Name' => 'Import', 'IsActive' => true]);
        $viewLink = ScMenuPermission::query()->create([
            'MenuID' => $menu->MenuID, 'PermissionID' => $view->PermissionID, 'IsActive' => true,
            'InputUser' => 'Security seeder', 'ModifUser' => 'Security seeder',
        ]);
        $importLink = ScMenuPermission::query()->create(['MenuID' => $menu->MenuID, 'PermissionID' => $import->PermissionID, 'IsActive' => true]);

        $seeder = new RolePermissionSeeder();
        $seeder->run();
        $seeder->run();

        $grant = ScRolePermission::query()->where('RoleID', $role->RoleID)->where('MenuPermissionID', $viewLink->MenuPermissionID)->firstOrFail();
        $this->assertSame(1, ScRolePermission::query()->where('RoleID', $role->RoleID)->where('MenuPermissionID', $viewLink->MenuPermissionID)->count());
        $this->assertDatabaseMissing('sc_role_permission', ['RoleID' => $role->RoleID, 'MenuPermissionID' => $importLink->MenuPermissionID]);

        $grant->update(['IsActive' => false]);
        $seeder->run();
        $this->assertFalse($grant->fresh()->IsActive);
    }

    public function test_menu_permission_seeder_uses_scoped_defaults_and_is_idempotent(): void
    {
        $asset = ScMenu::query()->create([
            'MenuID' => '01-00-00', 'Menu' => 'Asset',
            'Route' => 'master.asset.index', 'IsMenu' => true, 'IsActive' => true,
        ]);
        $email = ScMenu::query()->create([
            'MenuID' => '02-00-00', 'Menu' => 'Employee Email',
            'Route' => 'employee-email.index', 'IsMenu' => true, 'IsActive' => true,
        ]);
        (new NormalizedSecuritySeeder())->run();
        ScPermission::query()->create(['Name' => 'Import', 'IsActive' => true]);

        $seeder = new MenuPermissionSeeder();
        $seeder->run();
        $seeder->run();

        $assetPermissionCodes = ScMenuPermission::query()->where('MenuID', $asset->MenuID)
            ->with('permission')->get()->pluck('permission.Name')->all();
        $this->assertEqualsCanonicalizing(['View', 'Create', 'Update', 'Delete'], $assetPermissionCodes);
        $this->assertDatabaseHas('sc_menu_permission', [
            'MenuID' => $email->MenuID,
            'PermissionID' => ScPermission::query()->where('Name', 'IT Fulfillment')->value('PermissionID'),
        ]);
        $this->assertSame(4, ScMenuPermission::query()->where('MenuID', $asset->MenuID)->count());
        $this->assertSame(5, ScMenuPermission::query()->where('MenuID', $email->MenuID)->count());
        $this->assertDatabaseMissing('sc_menu_permission', [
            'MenuID' => $asset->MenuID,
            'PermissionID' => ScPermission::query()->where('Name', 'IT Fulfillment')->value('PermissionID'),
        ]);
    }

    private function fixture(): array
    {
        $user = ScUser::query()->create(['Username' => 'tester', 'Password' => 'x', 'IsActive' => true]);
        $role = ScRole::query()->create(['RoleID' => 'RL001', 'Role' => 'Tester', 'IsActive' => true]);
        $menu = ScMenu::query()->create(['MenuID' => '01-00-00', 'Menu' => 'Test', 'Route' => 'security.test.index', 'IsMenu' => true, 'IsActive' => true]);
        $view = ScPermission::query()->create(['Name' => 'View', 'IsActive' => true]);
        return [$user, $role, $menu, $view];
    }

    private function assignRole(ScUser $user, ScRole $role): void
    {
        ScUserRole::query()->create(['UserID' => $user->UserID, 'RoleID' => $role->RoleID, 'IsActive' => true]);
    }

    private function grant(ScRole $role, ScMenuPermission $permission): void
    {
        ScRolePermission::query()->create(['RoleID' => $role->RoleID, 'MenuPermissionID' => $permission->MenuPermissionID, 'IsActive' => true]);
    }

    private function grantRoutePermissions(ScUser $user, ScRole $role, ScMenu $menu, string $menuCode, string $route, array $permissionCodes): array
    {
        $menu->update(['Route' => $route]);
        $this->assignRole($user, $role);

        $links = [];
        foreach ($permissionCodes as $code) {
            $permission = ScPermission::query()->firstOrCreate(
                ['Name' => $code],
                ['Name' => $code, 'IsActive' => true]
            );
            $link = ScMenuPermission::query()->create([
                'MenuID' => $menu->MenuID, 'PermissionID' => $permission->PermissionID, 'IsActive' => true,
            ]);
            $this->grant($role, $link);
            $links[$code] = $link;
        }

        return $links;
    }

    private function auditColumns(Blueprint $table): void
    {
        $table->string('InputUser')->nullable(); $table->timestamp('InputDate')->nullable();
        $table->string('ModifUser')->nullable(); $table->timestamp('ModifDate')->nullable(); $table->string('DeletedBy')->nullable();
    }
}
