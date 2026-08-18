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
})->name('login')->middleware('guest');

Route::controller(AddDataController::class)->group(function(){
    Route::post('addDepartment', 'AddDepartment')->Middleware(Login::class);
    Route::post('addEmployee', 'addEmployee')->Middleware(Login::class);
    Route::post('addAssetType', 'AddAssetType')->Middleware(Login::class);
    Route::post('addStock', 'AddStock')->Middleware(Login::class);
    Route::post('addIssuance', 'AddIssuance')->Middleware(Login::class);
    Route::post('add-user', 'AddUser')->Middleware(Login::class);
});

Route::controller(FetchDataController::class)->group(function(){
    Route::get('addEmployee', 'FetchDepartmentList')->middleware(Login::class);
    Route::get('addStock', 'FetchAssetTypeList')->middleware(Login::class);
    Route::get('stocklist', 'FetchStockList')->middleware(Login::class);
    Route::get('departmentinfo', 'DepartmentList')->middleware(Login::class);
    Route::get('employeeinfo', 'EmployeeList')->middleware(Login::class);
    Route::get('assetTypeInfo', 'FetchAssetList')->middleware(Login::class);
    Route::get('addIssuance', 'AssetListIssuance')->middleware(Login::class);
    Route::get('issuance', 'IssuanceList')->middleware(Login::class);
    Route::get('stock-return', 'ReturnList')->middleware(Login::class);
    Route::get('issuance-history', 'IssuanceHistory')->middleware(Login::class);
    Route::get('userlist', 'UserList')->middleware(Login::class);
});

Route::view('addAsset','addAssetType')->middleware(Login::class);
Route::get('updateEmployee/{id}', [UpdateDataController::class, 'GetEmpID'])->name('editEmployee')->middleware(Login::class);
Route::get('updateStock/{id}', [UpdateDataController::class, 'GetStockID'])->name('editSt')->middleware(Login::class);
Route::get('updateIssuance/{id}', [UpdateDataController::class, 'GetIssuanceID'])->name('editIssuance')->middleware(Login::class);
Route::get('returnIssuance/{id}', [UpdateDataController::class, 'GetReturnID'])->name('returnIssuance')->middleware(Login::class);
Route::put('returnIssuance/{id}', [UpdateDataController::class, 'ReturnIssuance'])->middleware(Login::class);
Route::put('editEmployee/{id}', [UpdateDataController::class, 'UpdateEmployee'])->middleware(Login::class);
Route::put('editData/{id}', [UpdateDataController::class, 'UpdateStock'])->middleware(Login::class);
Route::put('editIssuance/{id}', [UpdateDataController::class, 'UpdateIssuance'])->middleware(Login::class);
Route::view('addDep','addDepartment')->middleware(Login::class);
Route::view('add-user','addUser')->middleware(Login::class);
Route::post('authenticate', [LoginController::class, 'Authenticate'])->middleware('guest');
Route::post('logout', [LoginController::class, 'Logout'])->middleware(Login::class);
Route::get('dashboard', [DashboardController::class, 'DashboardValues'])->middleware(Login::class);

