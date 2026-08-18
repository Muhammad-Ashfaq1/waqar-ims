<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddDataController;
use App\Http\Controllers\FetchDataController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\Login;
use App\Http\Controllers\UpdateDataController;

Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::controller(AddDataController::class)->group(function(){
    Route::post('addDepartment', 'AddDepartment')->Middleware(Login::class);
    Route::post('addEmployee', 'addEmployee')->Middleware(Login::class);
    Route::post('addAssetType', 'AddAssetType')->Middleware(Login::class);
    Route::post('addStock', 'AddStock')->Middleware(Login::class);
    Route::post('addIssuance', 'AddIssuance')->Middleware(Login::class);
    Route::post('add-user', 'AddUser')->Middleware(Login::class);
});

Route::controller(FetchDataController::class)->group(function(){
    Route::get('addEmployee', 'FetchDepartmentList');
    Route::get('addStock', 'FetchAssetTypeList');
    Route::get('stocklist', 'FetchStockList');
    Route::get('departmentinfo', 'DepartmentList')->Middleware(Login::class);
    Route::get('employeeinfo', 'EmployeeList')->Middleware(Login::class);
    Route::get('assetTypeInfo', 'FetchAssetList')->Middleware(Login::class);
    Route::get('addIssuance', 'AssetListIssuance')->Middleware(Login::class);
    Route::get('issuance', 'IssuanceList')->Middleware(Login::class);
    Route::get('userlist', 'UserList')->Middleware(Login::class);
});

Route::view('addAsset','addAssetType');
Route::get('updateEmployee/{id}', [UpdateDataController::class, 'GetEmpID'])->name('editEmployee');
Route::get('updateStock/{id}', [UpdateDataController::class, 'GetStockID'])->name('editSt');
Route::get('updateIssuance/{id}', [UpdateDataController::class, 'GetIssuanceID'])->name('editIssuance');
Route::put('editEmployee/{id}', [UpdateDataController::class, 'UpdateEmployee'])->middleware(Login::class);
Route::put('editData/{id}', [UpdateDataController::class, 'UpdateStock'])->middleware(Login::class);
Route::put('editIssuance/{id}', [UpdateDataController::class, 'UpdateIssuance'])->middleware(Login::class);
Route::view('addDep','addDepartment')->Middleware(Login::class);
Route::view('dashboard','dashboard')->Middleware(Login::class);
Route::view('add-user','addUser')->Middleware(Login::class);
Route::post('authenticate', [LoginController::class, 'Authenticate']);
Route::get('logout', [LoginController::class, 'Logout']);
Route::get('dashboard', [DashboardController::class, 'DashboardValues'])->middleware(Login::class);

