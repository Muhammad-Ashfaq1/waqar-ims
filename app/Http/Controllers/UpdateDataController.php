<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Stock;
use App\Models\Issuance;
use App\Models\User;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;

class UpdateDataController extends Controller
{
    //this function get ID of employee.
    public function GetEmpID ($id){
        $dep = Department::select()->get();
        $empID = Employee::with('GetDepartment')->find($id);
        return view('updateEmployee', ['empID' => $empID, 'dep' => $dep]);

    }
    //this function update employee data.
    public function UpdateEmployee(Request $request, $id){
        $request->validate([
            'designation' => 'required | string',
            'department' =>'required',
            'type' =>'required',
            'status' =>'required'
        ], [
            'designation.required' => 'Designation is Required',
            'department.required' => 'Department is Required',
            'type.required' => 'Type is Required',
            'status.required' => 'Status is Required'
        ]);

        $designation = $request->input('designation');
        $department = $request->input('department');
        $type = $request->input('type');
        $status = $request->input('status');

        $employee = Employee::find($id);
        $employee->designation = $designation;
        $employee->department_id = $department;
        $employee->type = $type;
        $employee->status = $status;
        $employee->save();

        toastr()->closeButton(true)->addSuccess('Employee data has been updated');
        return redirect('employeeinfo');
    }
    //this function get ID of Stock.
    public function GetStockID (Request $request, $id){
        $user = $request->user();
        if (! $user || (! $user->isSuperAdmin() && ! $user->hasRole('admin'))) {
            abort(403, 'Unauthorized. Only admin can edit stock.');
        }

        $stockID = Stock::with('GetAsset')->findOrFail($id);
        $assetlist = Asset::orderBy('type')->get();

        return view('updateStock', [
            'stockID' => $stockID,
            'assetlist' => $assetlist,
        ]);
    }
    //this function update stock data.
    public function UpdateStock(Request $request, $id){
        $user = $request->user();
        if (! $user || (! $user->isSuperAdmin() && ! $user->hasRole('admin'))) {
            abort(403, 'Unauthorized. Only admin can edit stock.');
        }

        $request->validate([
            'assettype'     => 'required|exists:assets,id',
            'model'         => 'required|string|max:255',
            'serial'        => 'required|string|max:255',
            'ram'           => 'nullable|string|max:255',
            'rom'           => 'nullable|string|max:255',
            'processor'     => 'nullable|string|max:255',
            'generation'    => 'nullable|string|max:255',
            'purchase_date' => 'required|date',
            'expiry_date'   => 'required|date',
            'status'        => 'required|string|max:255',
        ], [
            'assettype.required'     => 'Asset Type is required',
            'assettype.exists'       => 'Selected asset type is invalid',
            'model.required'         => 'Model is required',
            'serial.required'        => 'Serial No is required',
            'purchase_date.required' => 'Purchase Date is required',
            'purchase_date.date'     => 'Must be a valid date',
            'expiry_date.required'   => 'Expiry Date is required',
            'expiry_date.date'       => 'Must be a valid date',
            'status.required'        => 'Status is required',
        ]);

        $status = $request->input('status');

        $stock = Stock::findOrFail($id);
        $stock->asset_id = $request->input('assettype');
        $stock->model = $request->input('model');
        $stock->serial_no = $request->input('serial');
        $stock->ram = $request->input('ram');
        $stock->rom = $request->input('rom');
        $stock->processor = $request->input('processor');
        $stock->generation = $request->input('generation');
        $stock->purchase_date = $request->input('purchase_date');
        $stock->expiry_date = $request->input('expiry_date');
        $stock->status = $status;
        $stock->save();

        if ($status === Stock::STATUS_IN_STOCK) {
            Issuance::where('stock_id', $stock->id)
                ->whereNull('return_date')
                ->update(['return_date' => now()->toDateString()]);
        }

        toastr()->closeButton(true)->addSuccess('Stock has been updated');
        return redirect('stocklist');
    }
    //this function get ID of Issuance.
    public function GetIssuanceID ($id){
        $issueID = Issuance::with('GetStock.GetAsset', 'GetEmployee.GetDepartment', 'assignedLocation')->find($id);
        $emp = Employee::with('GetDepartment')->get();
        $locations = Location::active()->orderBy('name')->get();
        $locationDepartments = Location::active()->with('departments:id,dep_name')->get()
            ->mapWithKeys(fn (Location $location) => [$location->id => $location->departments->values()]);
        return view('updateIssuance', [
            'issuanceID' => $issueID,
            'emp' => $emp,
            'locations' => $locations,
            'locationDepartments' => $locationDepartments,
        ]);
    }
    //this function update issuance data.
    public function UpdateIssuance(Request $request, $id){
        $request->validate([
            'assign_to' => 'required|in:employee,location',
            'employee_id' => 'required_if:assign_to,employee|nullable|exists:employees,id',
            'location_id' => 'required|exists:locations,id',
            'department_id' => [
                'required_if:assign_to,location',
                'nullable',
                Rule::exists('department_location', 'department_id')->where(
                    fn ($query) => $query->where('location_id', $request->input('location_id'))
                ),
            ],
        ], [
            'assign_to.required' => 'Choose a employee or location',
            'assign_to.in' => 'Choose a employee or location',
            'employee_id.required_if' => 'Please choose a employee',
            'employee_id.exists' => 'Selected employee is invalid',
            'location_id.required' => 'Please choose a location',
            'location_id.exists' => 'Selected location is invalid',
            'department_id.required_if' => 'Please choose a department',
            'department_id.exists' => 'Selected department is not available at this location',
        ]);

        $location = Location::find($request->input('location_id'));
        if (! $location) {
            toastr()->error('Selected location is invalid');
            return redirect()->back()->withInput();
        }

        $issuance = Issuance::find($id);
        if (! $issuance) {
            toastr()->error('Issuance record not found');
            return redirect('issuance');
        }

        $issuance->employee_id = $request->input('assign_to') === 'employee' ? $request->input('employee_id') : null;
        $issuance->location_id = $location->id;
        $issuance->department_id = $request->input('assign_to') === 'location' ? $request->input('department_id') : null;
        $issuance->location = $location->name;
        $issuance->assignment_type = $request->input('assign_to');
        $issuance->save();

        toastr()->closeButton(true)->addSuccess('Issuance record has been updated');
        return redirect('issuance');
    }

    public function GetReturnID($id){
        $issuance = Issuance::with('GetStock.GetAsset', 'GetEmployee.GetDepartment', 'assignedLocation')->find($id);

        if (! $issuance || $issuance->return_date) {
            toastr()->error('This asset is already returned to stock.');
            return redirect('stock-return');
        }

        return view('returnIssuance', ['issuanceID' => $issuance]);
    }

    public function ReturnIssuance(Request $request, $id){
        $request->validate([
            'return_date' => 'required|date',
        ], [
            'return_date.required' => 'Return date is required',
            'return_date.date' => 'Must be a valid date',
        ]);

        $issuance = Issuance::find($id);

        if (! $issuance || $issuance->return_date) {
            toastr()->error('This asset is already returned to stock.');
            return redirect('stock-return');
        }

        if ($issuance->issuance_date && $request->input('return_date') < $issuance->issuance_date->format('Y-m-d')) {
            toastr()->error('Return date cannot be before issue date.');
            return redirect()->back()->withInput();
        }

        $issuance->return_date = $request->input('return_date');
        $issuance->save();

        Stock::where('id', $issuance->stock_id)->update([
            'status' => Stock::STATUS_IN_STOCK,
        ]);

        toastr()->closeButton(true)->addSuccess('Stock has been returned successfully');
        return redirect('stock-return');
    }

    public function GetUserID($id)
    {
        $userData = User::with('roles')->findOrFail($id);

        return view('updateUser', ['userData' => $userData]);
    }

    public function UpdateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $isSelf = (int) $user->id === (int) Auth::id();

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'nullable|string|max:100',
            'role'       => ['required', new Enum(UserRole::class)],
            'is_active'  => 'required|boolean',
            'password'   => 'nullable|min:8',
        ], [
            'first_name.required' => 'First name is required',
            'role.required'       => 'Role is required',
            'is_active.required'  => 'Status is required',
            'password.min'        => 'Password must be at least 8 characters long',
        ]);

        if ($isSelf && ! $request->boolean('is_active')) {
            toastr()->error('You cannot deactivate your own account.');
            return redirect()->back()->withInput();
        }

        $firstName = trim($request->input('first_name'));
        $lastName  = trim($request->input('last_name', ''));

        $user->first_name = $firstName;
        $user->last_name  = $lastName ?: null;
        $user->name       = trim($firstName.' '.($lastName ?: ''));
        $user->is_active  = $request->boolean('is_active');

        if ($request->filled('password')) {
            $user->password = $request->input('password');
        }

        $user->save();
        $user->syncRoles([$request->input('role')]);

        toastr()->closeButton(true)->addSuccess('User has been updated successfully.');

        return redirect('userlist');
    }

}
