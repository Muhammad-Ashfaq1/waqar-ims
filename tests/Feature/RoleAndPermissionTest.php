<?php

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\Asset;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Issuance;
use App\Models\Location;
use App\Models\Stock;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

describe('Role Permission Synchronization', function () {
    it('syncs exact permissions to Super Admin role', function () {
        $superAdminRole = \Spatie\Permission\Models\Role::findByName(UserRole::SuperAdmin->value, 'web');
        expect($superAdminRole->hasPermissionTo(UserPermission::UsersManage->value))->toBeTrue();
        expect($superAdminRole->hasPermissionTo(UserPermission::BaseDataManage->value))->toBeTrue();
        expect($superAdminRole->hasPermissionTo(UserPermission::InventoryManage->value))->toBeTrue();
    });

    it('syncs only inventory.manage to Inventory Manager role', function () {
        $invRole = \Spatie\Permission\Models\Role::findByName(UserRole::InventoryManager->value, 'web');
        expect($invRole->hasPermissionTo(UserPermission::InventoryManage->value))->toBeTrue();
        expect($invRole->hasPermissionTo(UserPermission::UsersManage->value))->toBeFalse();
        expect($invRole->hasPermissionTo(UserPermission::BaseDataManage->value))->toBeFalse();
    });

    it('syncs only view permissions and no write/manage permissions to Employee (Read Only) role', function () {
        $empRole = \Spatie\Permission\Models\Role::findByName(UserRole::Employee->value, 'web');
        expect($empRole->hasPermissionTo('dashboard.view'))->toBeTrue();
        expect($empRole->hasPermissionTo('inventory.view'))->toBeTrue();
        expect($empRole->hasPermissionTo('base-data.view'))->toBeTrue();
        expect($empRole->hasPermissionTo('inventory.manage'))->toBeFalse();
        expect($empRole->hasPermissionTo('base-data.manage'))->toBeFalse();
        expect($empRole->hasPermissionTo('users.manage'))->toBeFalse();
    });

    it('executes app:sync-permissions and permissions:sync console commands successfully', function () {
        $this->artisan('app:sync-permissions')
            ->expectsOutputToContain('All roles and permissions synchronized successfully.')
            ->assertSuccessful();

        $this->artisan('permissions:sync')
            ->assertSuccessful();
    });
});

describe('Role-based Passwords & Seeding', function () {
    it('seeds users with real-time secure role-distinct passwords and allows authentication', function () {
        // Super Admin
        $loginAdmin = $this->post('/authenticate', [
            'email' => 'admin@ims.lwmc.com',
            'password' => 'SuperAdmin@2026$!',
        ]);
        $loginAdmin->assertRedirect('dashboard');
        $this->assertAuthenticated();

        // Logout
        $this->post('/logout');
        $this->assertGuest();

        // Inventory Manager
        $loginInv = $this->post('/authenticate', [
            'email' => 'inventory@ims.lwmc.com',
            'password' => 'Inv#Mgr9824$Kz!',
        ]);
        $loginInv->assertRedirect('dashboard');
        $this->assertAuthenticated();

        // Logout
        $this->post('/logout');
        $this->assertGuest();

        // Read Only User
        $loginEmp = $this->post('/authenticate', [
            'email' => 'employee@ims.lwmc.com',
            'password' => 'ReadOnly!8391#Tv&',
        ]);
        $loginEmp->assertRedirect('dashboard');
        $this->assertAuthenticated();
    });

    it('rejects obsolete default "password" string', function () {
        $response = $this->post('/authenticate', [
            'email' => 'admin@ims.lwmc.com',
            'password' => 'password',
        ]);
        $response->assertRedirect('/');
        $this->assertGuest();
    });
});

describe('Super Admin Capabilities', function () {
    beforeEach(function () {
        $this->admin = User::where('email', 'admin@ims.lwmc.com')->first();
        $this->actingAs($this->admin);
    });

    it('can access dashboard and all base data & inventory views', function () {
        $this->get('/dashboard')->assertOk();
        $this->get('/departmentinfo')->assertOk();
        $this->get('/employeeinfo')->assertOk();
        $this->get('/locationinfo')->assertOk();
        $this->get('/assetTypeInfo')->assertOk();
        $this->get('/stocklist')->assertOk();
        $this->get('/issuance')->assertOk();
        $this->get('/stock-return')->assertOk();
        $this->get('/issuance-history')->assertOk();
        $this->get('/userlist')->assertOk();
    });

    it('can create new base data records (department, asset type, employee, location)', function () {
        // Add Department
        $depRes = $this->post('/addDepartment', ['department' => 'Finance']);
        $depRes->assertRedirect('addDep');
        $this->assertDatabaseHas('departments', ['dep_name' => 'Finance']);

        $dep = Department::first();

        // Add Asset Type
        $assetRes = $this->post('/addAssetType', ['assettype' => 'Monitor']);
        $assetRes->assertRedirect('addAsset');
        $this->assertDatabaseHas('assets', ['type' => 'Monitor']);

        // Add Employee
        $empRes = $this->post('/addEmployee', [
            'empname' => 'Ali Khan',
            'designation' => 'Officer',
            'department' => $dep->id,
            'type' => 'Regular',
            'status' => 'Active',
        ]);
        $empRes->assertRedirect('addEmployee');
        $this->assertDatabaseHas('employees', ['emp_name' => 'Ali Khan']);

        // Add Location
        $locRes = $this->post('/add-location', [
            'name' => 'Outfall Workshop',
            'slug' => 'outfall-workshop',
            'location_type' => 'workshop',
            'is_active' => '1',
        ]);
        $locRes->assertRedirect('locationinfo');
        $this->assertDatabaseHas('locations', ['name' => 'Outfall Workshop']);
    });

    it('can create new users and assign any role', function () {
        $response = $this->post('/add-user', [
            'first_name' => 'Sara',
            'last_name' => 'Ahmed',
            'email' => 'sara@ims.lwmc.com',
            'password' => 'SecurePass#2026!',
            'role' => UserRole::InventoryManager->value,
        ]);

        $response->assertRedirect('userlist');
        $newUser = User::where('email', 'sara@ims.lwmc.com')->first();
        expect($newUser)->not->toBeNull();
        expect($newUser->hasRole(UserRole::InventoryManager->value))->toBeTrue();
        expect($newUser->is_active)->toBeTrue();
    });

    it('can edit a user and make them inactive', function () {
        $targetUser = User::where('email', 'employee@ims.lwmc.com')->first();

        $response = $this->put("/editUser/{$targetUser->id}", [
            'first_name' => 'Read',
            'last_name' => 'User Updated',
            'role' => UserRole::Employee->value,
            'is_active' => '0',
        ]);

        $response->assertRedirect('userlist');
        $targetUser->refresh();
        expect($targetUser->is_active)->toBeFalse();
    });

    it('cannot deactivate own account', function () {
        $response = $this->from('/userlist')->put("/editUser/{$this->admin->id}", [
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'role' => UserRole::SuperAdmin->value,
            'is_active' => '0',
        ]);

        $response->assertRedirect('/userlist');
        $this->admin->refresh();
        expect($this->admin->is_active)->toBeTrue();
    });

    it('can perform inventory operations (add stock, issuance, return)', function () {
        $asset = Asset::create(['type' => 'Laptop']);
        $dep = Department::create(['dep_name' => 'IT']);
        $emp = Employee::create([
            'emp_name' => 'John Doe',
            'designation' => 'Engineer',
            'department_id' => $dep->id,
            'type' => 'Permanent',
            'status' => 'Active',
        ]);

        // Add Stock
        $this->post('/addStock', [
            'assettype' => $asset->id,
            'model' => 'Latitude 7420',
            'serial' => 'SN-12345',
            'purchase_date' => '2026-01-01',
            'expiry_date' => '2029-01-01',
            'status' => Stock::STATUS_IN_STOCK,
        ])->assertRedirect('addStock');

        $stock = Stock::where('serial_no', 'SN-12345')->first();
        expect($stock)->not->toBeNull();

        // Issue Stock to Employee
        $this->post('/addIssuance', [
            'assign_to' => 'employee',
            'employee_id' => $emp->id,
            'stock_id' => $stock->id,
            'issuance_date' => '2026-02-01',
        ])->assertRedirect('addIssuance');

        $stock->refresh();
        expect($stock->status)->toBe(Stock::STATUS_ISSUED);

        $issuance = Issuance::where('stock_id', $stock->id)->whereNull('return_date')->first();
        expect($issuance)->not->toBeNull();

        // Return Stock
        $this->put("/returnIssuance/{$issuance->id}", [
            'return_date' => '2026-03-01',
        ])->assertRedirect('stock-return');

        $stock->refresh();
        expect($stock->status)->toBe(Stock::STATUS_IN_STOCK);
    });
});

describe('Inventory Manager Capabilities & Restrictions', function () {
    beforeEach(function () {
        $this->inventoryUser = User::where('email', 'inventory@ims.lwmc.com')->first();
        $this->actingAs($this->inventoryUser);
    });

    it('can add stock and perform issuance and returns', function () {
        $asset = Asset::create(['type' => 'Desktop']);
        $dep = Department::create(['dep_name' => 'Operations']);
        $emp = Employee::create([
            'emp_name' => 'Jane Smith',
            'designation' => 'Supervisor',
            'department_id' => $dep->id,
            'type' => 'Permanent',
            'status' => 'Active',
        ]);

        // Add Stock
        $this->post('/addStock', [
            'assettype' => $asset->id,
            'model' => 'OptiPlex 7080',
            'serial' => 'DESK-9988',
            'purchase_date' => '2026-01-10',
            'expiry_date' => '2030-01-10',
            'status' => Stock::STATUS_IN_STOCK,
        ])->assertRedirect('addStock');

        $stock = Stock::where('serial_no', 'DESK-9988')->first();
        expect($stock)->not->toBeNull();

        // Issue Stock
        $this->post('/addIssuance', [
            'assign_to' => 'employee',
            'employee_id' => $emp->id,
            'stock_id' => $stock->id,
            'issuance_date' => '2026-02-15',
        ])->assertRedirect('addIssuance');

        $issuance = Issuance::where('stock_id', $stock->id)->whereNull('return_date')->first();

        // Return Stock
        $this->put("/returnIssuance/{$issuance->id}", [
            'return_date' => '2026-04-01',
        ])->assertRedirect('stock-return');

        $stock->refresh();
        expect($stock->status)->toBe(Stock::STATUS_IN_STOCK);
    });

    it('cannot manage users (add, edit, list)', function () {
        $this->get('/userlist')->assertForbidden();
        $this->get('/add-user')->assertForbidden();
        $this->post('/add-user', [
            'first_name' => 'Hacked',
            'email' => 'hack@ims.lwmc.com',
            'password' => 'secret1234',
            'role' => UserRole::SuperAdmin->value,
        ])->assertForbidden();
    });

    it('cannot modify base data (create departments, employees, locations)', function () {
        $this->get('/addDep')->assertForbidden();
        $this->post('/addDepartment', ['department' => 'Illegal Dep'])->assertForbidden();

        $this->get('/add-location')->assertForbidden();
        $this->post('/add-location', [
            'name' => 'Illegal Location',
            'slug' => 'illegal-location',
            'location_type' => 'workshop',
        ])->assertForbidden();
    });

    it('can view read-only lists and dashboard', function () {
        $this->get('/dashboard')->assertOk();
        $this->get('/departmentinfo')->assertOk();
        $this->get('/employeeinfo')->assertOk();
        $this->get('/locationinfo')->assertOk();
        $this->get('/stocklist')->assertOk();
        $this->get('/issuance')->assertOk();
    });
});

describe('Read Only User Restrictions', function () {
    beforeEach(function () {
        $this->readOnlyUser = User::where('email', 'employee@ims.lwmc.com')->first();
        $this->actingAs($this->readOnlyUser);
    });

    it('can view all read views', function () {
        $this->get('/dashboard')->assertOk();
        $this->get('/departmentinfo')->assertOk();
        $this->get('/employeeinfo')->assertOk();
        $this->get('/locationinfo')->assertOk();
        $this->get('/assetTypeInfo')->assertOk();
        $this->get('/stocklist')->assertOk();
        $this->get('/issuance')->assertOk();
        $this->get('/stock-return')->assertOk();
        $this->get('/issuance-history')->assertOk();
        $this->get('/profile')->assertOk();
    });

    it('cannot access user management', function () {
        $this->get('/userlist')->assertForbidden();
        $this->get('/add-user')->assertForbidden();
        $this->post('/add-user', [])->assertForbidden();
    });

    it('cannot access base data creation/modification', function () {
        $this->get('/addDep')->assertForbidden();
        $this->post('/addDepartment', ['department' => 'Test'])->assertForbidden();
        $this->get('/addEmployee')->assertForbidden();
        $this->post('/addEmployee', [])->assertForbidden();
        $this->get('/add-location')->assertForbidden();
        $this->post('/add-location', [])->assertForbidden();
    });

    it('cannot access inventory management (add stock, issuance, return)', function () {
        $this->get('/addStock')->assertForbidden();
        $this->post('/addStock', [])->assertForbidden();
        $this->get('/addIssuance')->assertForbidden();
        $this->post('/addIssuance', [])->assertForbidden();
    });

    it('does not render add or action buttons in the UI for read-only users', function () {
        $this->get('/departmentinfo')->assertDontSee('addDep');
        $this->get('/employeeinfo')->assertDontSee('addEmployee');
        $this->get('/locationinfo')->assertDontSee('add-location');
        $this->get('/assetTypeInfo')->assertDontSee('addAsset');
        $this->get('/stocklist')->assertDontSee('addStock');
        $this->get('/issuance')->assertDontSee('addIssuance');
        $this->get('/dashboard')->assertDontSee('addIssuance');
    });
});

describe('Inactive User Blocking', function () {
    it('blocks login for inactive users with an error message', function () {
        $user = User::where('email', 'employee@ims.lwmc.com')->first();
        $user->is_active = false;
        $user->save();

        $response = $this->post('/authenticate', [
            'email' => 'employee@ims.lwmc.com',
            'password' => 'ReadOnly!8391#Tv&',
        ]);

        $response->assertRedirect('/');
        $this->assertGuest();
    });

    it('logs out and redirects active session if user account becomes inactive', function () {
        $user = User::where('email', 'employee@ims.lwmc.com')->first();
        $this->actingAs($user);

        // Deactivate user in database
        $user->is_active = false;
        $user->save();

        // Attempting to access dashboard should trigger middleware logout
        $response = $this->get('/dashboard');
        $response->assertRedirect('/');
        $this->assertGuest();
    });
});
