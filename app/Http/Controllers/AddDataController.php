<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Asset;
use App\Models\Stock;
use App\Models\Issuance;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;




class AddDataController extends Controller
{
    function addDepartment(Request $request){

        $request->validate([
            'department' => 'required | string'
        ], [
            'department.required' => 'Department is Required'
        ]);
        $insertData = [
            'dep_name' => $request->input('department'),
            'created_at' => Carbon::now()
        ];

        $response = Department::insert($insertData);
        if($response){
            toastr()->closeButton(true)->addSuccess('Department has been added successfully');
            return redirect('addDep');
        }
    }

    function addEmployee(Request $request){

        $request->validate([
            'empname' => 'required | string',
            'designation' => 'required | string',
            'department' =>'required',
            'type' =>'required',
            'status' =>'required'
        ], [
            'empname.required' => 'Name is Required',
            'designation.required' => 'Designation is Required',
            'department.required' => 'Department is Required',
            'type.required' => 'Type is Required',
            'status.required' => 'Status is Required'
        ]);
        $insertEmployee = [
            'emp_name' => $request->input('empname'),
            'designation' => $request->input('designation'),
            'department_id' => $request->input('department'),
            'type' => $request->input('type'),
            'status' => $request->input('status'),
            'created_at' => Carbon::now()
        ];
        $response = Employee::insert($insertEmployee);
        if($response){
            toastr()->closeButton(true)->addSuccess('Employee has been added successfully');
            return redirect('addEmployee');
        }
    }
    function AddAssetType(Request $request){

            $request->validate([
                'assettype' => 'required | string',
            ], [
                'assettype.required' => 'Asset Type is required',
                'assettype.string' => 'Must be a string'
            ]);
            $insertAssetType = [
                'type' => $request->input('assettype'),
                'created_at' => Carbon::now()
            ];
            $response = Asset::insert($insertAssetType);
            if($response){
                toastr()->closeButton(true)->addSuccess('Asset Type has been added successfully');
            return redirect('addAsset');
            }
    }
    function AddStock(Request $request){
        $request->validate([
            'assettype' =>'required',
            'model' =>'required | string',
            'serial' =>'required | string',
            'purchase_date' =>'required | date',
            'expiry_date' =>'required | date',
            'status' =>'required'
        ],[
            'assettype.required' => 'Asset Type is required',
           'model.required' => 'Model is required',
           'model.string' => 'Must be a string',
           'serial.required' => 'Serial No is required',
           'serial.string' => 'Must be a string',
            'purchase_date.required' => 'Purchase Date is must',
            'purchase_date.date' => 'Must be a valid date',
            'expiry_date.required' => 'Expiry Date is must',
            'expiry_date.date' => 'Must be a valid date',
           'status.required' => 'Status is required'
        ]);
        $insertStock = [
            'asset_id' => $request->input('assettype'),
            'model' => $request->input('model'),
            'serial_no' => $request->input('serial'),
            'ram' => $request->input('ram'),
            'rom' => $request->input('rom'),
            'processor' => $request->input('processor'),
            'generation' => $request->input('generation'),
            'purchase_date' => $request->input('purchase_date'),
            'expiry_date' => $request->input('expiry_date'),
            'status' => $request->input('status'),
            'created_at' => Carbon::now()
        ];
        $response = Stock::insert($insertStock);
        if($response){
            toastr()->closeButton(true)->addSuccess('Stock has been added successfully');
            return redirect('addStock');
        }
    }
    function AddIssuance (Request $request){

        $request->validate([
            'employee_id' =>'required',
            'stock_id' =>'required',
            'issuance_date' =>'required',
            'location' => 'required'
        ],[
            'employee_id.required' => 'Employee is required',
            'stock_id.required' => 'Stock is required',
            'issuance_date.required' => 'Date is required',
            'location.required' => 'Location is required'
        ]);
        $insertIssuance = [
            'stock_id' => $request->input('stock_id'),
            'employee_id' => $request->input('employee_id'),
            'issuance_date' => $request->input('issuance_date'),
            'location' => $request->input('location'),
            'created_at' => Carbon::now()
        ];
        $response = Issuance::insert($insertIssuance);
        Stock::where('id', $request->input('stock_id'))->update([
            'status' => 'Issued'
        ]);
        if($response){
            toastr()->closeButton(true)->addSuccess('Stock has been issued successfully');
            return redirect('addIssuance');
        }
    }
    function AddUser (Request $request){
        $request->validate([
            'name' => 'required | string',
            'email' => 'required | email',
            'password' => 'required | min:6'
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters long'
        ]);
        $insertUser = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'created_at' => Carbon::now()
        ];

            $response = User::insert($insertUser);
            if($response){
                toastr()->closeButton(true)->addSuccess('User has been added successfully');
                return redirect('add-user');
            }


    }
}
