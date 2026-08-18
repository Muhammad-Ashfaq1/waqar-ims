<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Asset;
use App\Models\Stock;
use App\Models\Issuance;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class FetchDataController extends Controller
{
    // Fetching department data from database and passing it to the departmentInfo view
    function DepartmentList (){
        $departments = Department::all();
        return view('departmentInfo', ['depdata' => $departments]);
    }

    // Fetching department data from database and passing it to the Employee Dropdown view
    function FetchDepartmentList() {
        $depList = DB::table('departments')->select()->get();
        return view('addemployee', ['depdata' => $depList]);
    }

    // Fetching employee data from database and passing it to the employeeInfo view
    function EmployeeList() {
        $employees = Employee::with('GetDepartment')->get();
        return view('employeeInfo', ['empdata' => $employees]);

    }

    // Fetching asset type data from database and passing it to the assetType view
    function FetchAssetList(){
        $assets = Asset::select()->get();
        return view('assetType', ['assetdata' => $assets]);
    }

    //Fetch Stock List data rom database and passing it to the stockList view
    function FetchStockList(){
        $stock = Stock::with('GetAsset')->where('status','In Stock')->get();
        return view('stockList', ['stockdata' => $stock]);
    }
    //Fetch Asset List data rom database and passing it to the stockList Dropdown view
    function FetchAssetTypeList() {
        $AssetList = DB::table('assets')->select()->get();
        return view('addStock', ['assetlist' => $AssetList]);

    }
    //Fetch Asset List data rom database and passing it to the asset issuance view
    function AssetListIssuance() {
        $AssetList = Stock::with('GetAsset')->where('status', Stock::STATUS_IN_STOCK)->get();
        $empList = Employee::with('GetDepartment')->where('status', 'Active')->get();
        return view('addIssuance', ['assetlist' => $AssetList, 'emplist' => $empList]);

    }
    // Fetching issuance data from database and passing it to the issuanceInfo view
    function IssuanceList() {
        $issuances = Issuance::with('getStock.getAsset', 'getEmployee.getDepartment')
        ->whereHas('getStock', function($query){$query->where('status','Issued');})->get();
        return view('issuanceList', ['issuancedata' => $issuances]);
    }
    // Fetching user data from database and passing it to the userList view  (Not in use)  -- This is for admin only to view all users.  Not for regular users.  --
    function UserList() {
        $users = User::select()->get();
        return view('user', ['userdata' => $users]);
    }

}
