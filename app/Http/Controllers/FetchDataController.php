<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Asset;
use App\Models\Stock;
use App\Models\Issuance;
use App\Models\User;
use App\Models\Location;
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
        return view('addEmployee', ['depdata' => $depList]);
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
        $locations = Location::active()->orderBy('name')->get();
        $locationDepartments = Location::active()->with('departments:id,dep_name')->get()
            ->mapWithKeys(fn (Location $location) => [$location->id => $location->departments->values()]);
        return view('addIssuance', [
            'assetlist' => $AssetList,
            'emplist' => $empList,
            'locations' => $locations,
            'locationDepartments' => $locationDepartments,
        ]);

    }
    // Fetching issuance data from database and passing it to the issuanceInfo view
    function IssuanceList() {
        $issuances = Issuance::with('getStock.getAsset', 'getEmployee.getDepartment', 'assignedLocation', 'assignedDepartment')
            ->whereNull('return_date')
            ->orderByDesc('issuance_date')
            ->orderByDesc('id')
            ->get();
        return view('issuanceList', ['issuancedata' => $issuances]);
    }

    function ReturnList() {
        $issuances = Issuance::with('getStock.getAsset', 'getEmployee.getDepartment', 'assignedLocation', 'assignedDepartment')
            ->whereNull('return_date')
            ->orderByDesc('issuance_date')
            ->orderByDesc('id')
            ->get();
        return view('stockReturn', ['issuancedata' => $issuances]);
    }

    function IssuanceHistory(Request $request) {
        $query = Issuance::with('getStock.getAsset', 'getEmployee.getDepartment', 'assignedLocation', 'assignedDepartment');

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }
        if ($request->filled('stock_id')) {
            $query->where('stock_id', $request->stock_id);
        } elseif ($request->filled('asset_id')) {
            $query->whereHas('getStock', function ($stockQuery) use ($request) {
                $stockQuery->where('asset_id', $request->asset_id);
            });
        }
        if ($request->filled('from_date')) {
            $query->whereDate('issuance_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('issuance_date', '<=', $request->to_date);
        }
        if ($request->status === 'issued') {
            $query->whereNull('return_date');
        } elseif ($request->status === 'returned') {
            $query->whereNotNull('return_date');
        }

        if ($request->filled('stock_id')) {
            $query->orderBy('issuance_date')->orderBy('id');
        } else {
            $query->orderByDesc('issuance_date')->orderByDesc('id');
        }

        $history = $query->get();
        $selectedStock = $request->filled('stock_id')
            ? Stock::with('getAsset')->find($request->stock_id)
            : null;

        return view('issuanceHistory', [
            'history' => $history,
            'employees' => Employee::with('GetDepartment')->orderBy('emp_name')->get(),
            'assets' => Asset::orderBy('type')->get(),
            'stocks' => Stock::with('getAsset')->orderBy('serial_no')->get(),
            'selectedStock' => $selectedStock,
            'issuedCount' => $history->whereNull('return_date')->count(),
            'returnedCount' => $history->whereNotNull('return_date')->count(),
        ]);
    }
    // Fetching user data from database and passing it to the userList view  (Not in use)  -- This is for admin only to view all users.  Not for regular users.  --
    function UserList() {
        $users = User::with('roles')->get();
        return view('user', ['userdata' => $users]);
    }

}
