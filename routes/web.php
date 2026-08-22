<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddDataController;
use App\Http\Controllers\FetchDataController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\Login;
use App\Http\Controllers\UpdateDataController;
use App\Http\Controllers\ProfileController;
use App\Enums\UserPermission;

Route::get('/', function () {
    return view('welcome');
})->name('login')->middleware('guest');

Route::post('authenticate', [LoginController::class, 'Authenticate'])->middleware('guest');
Route::post('logout', [LoginController::class, 'Logout'])->middleware(Login::class);

Route::middleware(Login::class)->group(function () {
    Route::get('dashboard', [DashboardController::class, 'DashboardValues']);
    Route::get('profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('profile', [ProfileController::class, 'update']);
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::controller(FetchDataController::class)->group(function () {
        Route::get('stocklist', 'FetchStockList');
        Route::get('departmentinfo', 'DepartmentList');
        Route::get('employeeinfo', 'EmployeeList');
        Route::get('assetTypeInfo', 'FetchAssetList');
        Route::get('issuance', 'IssuanceList');
        Route::get('stock-return', 'ReturnList');
        Route::get('issuance-history', 'IssuanceHistory');
    });
});

Route::middleware([Login::class, 'permission:'.UserPermission::BaseDataManage->value])->group(function () {
    Route::controller(AddDataController::class)->group(function () {
        Route::post('addDepartment', 'AddDepartment');
        Route::post('addEmployee', 'addEmployee');
        Route::post('addAssetType', 'AddAssetType');
    });

    Route::controller(FetchDataController::class)->group(function () {
        Route::get('addEmployee', 'FetchDepartmentList');
    });

    Route::view('addAsset', 'addAssetType');
    Route::view('addDep', 'addDepartment');

    Route::get('updateEmployee/{id}', [UpdateDataController::class, 'GetEmpID'])->name('editEmployee');
    Route::put('editEmployee/{id}', [UpdateDataController::class, 'UpdateEmployee']);
});

Route::middleware([Login::class, 'permission:'.UserPermission::UsersManage->value])->group(function () {
    Route::controller(AddDataController::class)->group(function () {
        Route::post('add-user', 'AddUser');
    });

    Route::controller(FetchDataController::class)->group(function () {
        Route::get('userlist', 'UserList');
    });

    Route::view('add-user', 'addUser');
    Route::get('updateUser/{id}', [UpdateDataController::class, 'GetUserID'])->name('editUser');
    Route::put('editUser/{id}', [UpdateDataController::class, 'UpdateUser'])->name('users.update');
});

Route::middleware([Login::class, 'permission:'.UserPermission::InventoryManage->value])->group(function () {
    Route::controller(AddDataController::class)->group(function () {
        Route::post('addStock', 'AddStock');
        Route::post('addIssuance', 'AddIssuance');
    });

    Route::controller(FetchDataController::class)->group(function () {
        Route::get('addStock', 'FetchAssetTypeList');
        Route::get('addIssuance', 'AssetListIssuance');
    });

    Route::get('updateStock/{id}', [UpdateDataController::class, 'GetStockID'])->name('editSt');
    Route::get('updateIssuance/{id}', [UpdateDataController::class, 'GetIssuanceID'])->name('editIssuance');
    Route::get('returnIssuance/{id}', [UpdateDataController::class, 'GetReturnID'])->name('returnIssuance');
    Route::put('returnIssuance/{id}', [UpdateDataController::class, 'ReturnIssuance']);
    Route::put('editData/{id}', [UpdateDataController::class, 'UpdateStock']);
    Route::put('editIssuance/{id}', [UpdateDataController::class, 'UpdateIssuance']);
});
