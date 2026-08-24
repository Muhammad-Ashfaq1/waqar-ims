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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Enums\UserRole;
use Illuminate\Validation\Rules\Enum;




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
            'status' =>'required',
            'location_id' => 'nullable|exists:locations,id',
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
           'status.required' => 'Status is required',
           'location_id.exists' => 'Selected location is invalid',
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
            'location_id' => $request->input('location_id') ?: null,
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
            'assign_to' => 'required|in:employee,location',
            'employee_id' => 'required_if:assign_to,employee|nullable|exists:employees,id',
            'stock_id' => 'required|exists:stocks,id',
            'issuance_date' => 'required|date',
            'location_id' => 'required_if:assign_to,location|nullable|exists:locations,id',
        ],[
            'assign_to.required' => 'Choose a employee or location',
            'assign_to.in' => 'Choose a employee or location',
            'employee_id.required_if' => 'Please choose a employee',
            'employee_id.exists' => 'Selected employee is invalid',
            'stock_id.required' => 'Please select a stock item',
            'stock_id.exists' => 'Selected stock is invalid',
            'issuance_date.required' => 'Please select the issuance date',
            'issuance_date.date' => 'Please enter a valid issuance date',
            'location_id.required_if' => 'Please choose a location',
            'location_id.exists' => 'Selected location is invalid',
        ]);
        $stock = Stock::find($request->input('stock_id'));
        if (!$stock || $stock->status !== Stock::STATUS_IN_STOCK) {
            toastr()->error('This asset is not available in stock.');
            return redirect()->back()->withInput();
        }

        $location = $request->input('assign_to') === 'location'
            ? Location::find($request->input('location_id'))
            : null;
        if ($request->input('assign_to') === 'location' && ! $location) {
            toastr()->error('Selected location is invalid');
            return redirect()->back()->withInput();
        }

        DB::transaction(function () use ($request, $stock, $location) {
            Issuance::where('stock_id', $stock->id)
                ->whereNull('return_date')
                ->update(['return_date' => Carbon::now()->toDateString()]);

            Issuance::insert([
                'stock_id' => $stock->id,
                'employee_id' => $request->input('assign_to') === 'employee' ? $request->input('employee_id') : null,
                'issuance_date' => $request->input('issuance_date'),
                'location_id' => $location?->id,
                'location' => $location?->name,
                'assignment_type' => $request->input('assign_to'),
                'created_at' => Carbon::now(),
            ]);

            $stockUpdate = ['status' => Stock::STATUS_ISSUED];
            if ($location) {
                $stockUpdate['location_id'] = $location->id;
            }
            Stock::where('id', $stock->id)->update($stockUpdate);
        });

        toastr()->closeButton(true)->addSuccess('Stock has been issued successfully');
        return redirect('addIssuance');
    }
    function AddUser (Request $request){
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'nullable|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:8',
            'role'       => ['required', new Enum(UserRole::class)],
        ], [
            'first_name.required' => 'First name is required',
            'email.required'      => 'Email is required',
            'email.unique'        => 'This email is already registered',
            'password.required'   => 'Password is required',
            'password.min'        => 'Password must be at least 8 characters long',
            'role.required'       => 'Role is required',
            'role.in'             => 'Invalid role selected',
        ]);

        $firstName = trim($request->input('first_name'));
        $lastName  = trim($request->input('last_name', ''));
        $fullName  = trim($firstName . ' ' . $lastName);

        $user = User::create([
            'name'       => $fullName,
            'first_name' => $firstName,
            'last_name'  => $lastName ?: null,
            'email'      => $request->input('email'),
            'password'   => $request->input('password'),
            'is_active'  => true,
        ]);

        $user->assignRole($request->enum('role', UserRole::class)->value);

        toastr()->closeButton(true)->addSuccess('User has been added successfully');

        return redirect('userlist');
    }
}
