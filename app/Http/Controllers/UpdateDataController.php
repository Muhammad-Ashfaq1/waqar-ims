<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Stock;
use App\Models\Issuance;

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
    public function GetStockID ($id){
        $stockID = Stock::with('GetAsset')->find($id);
        return view('updateStock', ['stockID' => $stockID]);
    }
    //this function update stock data.
    public function UpdateStock(Request $request, $id){
        $status = $request->input('status');

        $stock = Stock::find($id);
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
        $issueID = Issuance::with('GetStock.GetAsset', 'GetEmployee.GetDepartment')->find($id);
        $emp = Employee::with('GetDepartment')->get();
        return view('updateIssuance', ['issuanceID' => $issueID, 'emp' => $emp]);
    }
    //this function update issuance data.
    public function UpdateIssuance(Request $request, $id){
        $empID = $request->input('employee_id');
        $location = $request->input('location');
        $status = $request->input('status');
        $stockID = $request->input('stock_id');

        $issuance = Issuance::find($id);
        $issuance->employee_id = $empID;
        $issuance->location = $location;

        if ($status == Stock::STATUS_IN_STOCK) {
            $issuance->return_date = $request->input('return_date') ?: now()->toDateString();
            $issuance->save();
            Stock::where('id', $stockID)->update([
                'status' => Stock::STATUS_IN_STOCK
            ]);
        } else {
            $issuance->save();
        }

        toastr()->closeButton(true)->addSuccess('Issuance record has been updated');
        return redirect('issuance');
    }

}
