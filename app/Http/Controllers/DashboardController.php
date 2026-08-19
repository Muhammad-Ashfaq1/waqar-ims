<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Issuance;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function DashboardValues(){
        $employee = Employee::count();
        $activeEmployees = Employee::where('status', 'Active')->count();
        $departmentCount = Department::count();
        $assetTypeCount = Asset::count();
        $pendingReturns = Issuance::whereNull('return_date')->count();
        $issuedThisMonth = Issuance::whereYear('issuance_date', now()->year)
            ->whereMonth('issuance_date', now()->month)
            ->count();
        $returnedThisMonth = Issuance::whereNotNull('return_date')
            ->whereYear('return_date', now()->year)
            ->whereMonth('return_date', now()->month)
            ->count();
        $expiredCount = Stock::whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<', now()->toDateString())
            ->count();
        $expiringSoonCount = Stock::whereNotNull('expiry_date')
            ->whereDate('expiry_date', '>=', now()->toDateString())
            ->whereDate('expiry_date', '<=', now()->addDays(90)->toDateString())
            ->count();

        $stockByType = DB::table('stocks')
            ->join('assets', 'assets.id', '=', 'stocks.asset_id')
            ->select(
                'assets.type',
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CASE WHEN stocks.status = 'In Stock' THEN 1 ELSE 0 END) as in_stock"),
                DB::raw("SUM(CASE WHEN stocks.status = 'Issued' THEN 1 ELSE 0 END) as issued")
            )
            ->groupBy('assets.type')
            ->orderBy('assets.type')
            ->get();

        $issuedByDepartment = DB::table('issuances')
            ->join('employees', 'employees.id', '=', 'issuances.employee_id')
            ->leftJoin('departments', 'departments.id', '=', 'employees.department_id')
            ->whereNull('issuances.return_date')
            ->select(
                DB::raw("COALESCE(departments.dep_name, 'Unassigned') as dep_name"),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('departments.dep_name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $recentIssuances = Issuance::with('getStock.getAsset', 'getEmployee.getDepartment')
            ->orderByDesc('issuance_date')
            ->orderByDesc('id')
            ->limit(8)
            ->get();

        $recentReturns = Issuance::with('getStock.getAsset', 'getEmployee.getDepartment')
            ->whereNotNull('return_date')
            ->orderByDesc('return_date')
            ->orderByDesc('id')
            ->limit(8)
            ->get();

        // Monthly issuances & returns — last 6 months
        $monthlyData = collect(range(5, 0))->map(function ($i) {
            $date = now()->subMonths($i);
            return [
                'month'    => $date->format('M Y'),
                'issued'   => Issuance::whereYear('issuance_date', $date->year)->whereMonth('issuance_date', $date->month)->count(),
                'returned' => Issuance::whereNotNull('return_date')->whereYear('return_date', $date->year)->whereMonth('return_date', $date->month)->count(),
            ];
        });

        $longestHeld = Issuance::with('getStock.getAsset', 'getEmployee.getDepartment')
            ->whereNull('return_date')
            ->orderBy('issuance_date')
            ->orderBy('id')
            ->limit(8)
            ->get();
        $laptop = Stock::where('asset_id','6')->count();
        $desktop = Stock::where('asset_id','3')->count();
        $printer = Stock::where('asset_id','8')->count();
        $scanner = Stock::where('asset_id','9')->count();
        $allinone = Stock::where('asset_id','2')->count();
        $tablet = Stock::where('asset_id','10')->count();
        $server = Stock::where('asset_id','11')->count();
        $AP = Stock::where('asset_id','12')->count();
        $NVR = Stock::where('asset_id','13')->count();
        $NS = Stock::where('asset_id','14')->count();
        $LED = Stock::where('asset_id','15')->count();
        $D1 = Stock::where('model','HP Elite-Desk-800')->count();
        $D2 = Stock::where('model','Accer Veriton M275')->count();
        $D3 = Stock::where('model','Dell Optiplex 3080')->count();
        $D4 = Stock::where('model','Dell Optiplex 3010')->count();
        $D5 = Stock::where('model','Dell Optiplex 3090')->count();
        $D6 = Stock::where('model','Dell Optiplex 5050')->count();
        $D7 = Stock::where('model','Dell Optiplex 7010')->count();
        $D8 = Stock::where('model','Dell Optiplex 7020')->count();
        $D9 = Stock::where('model','Dell OptiPlex 7080')->count();
        $D10 = Stock::where('model','Dell Optiplex 9010')->count();
        $D11 = Stock::where('model','Dell OptiPlex 9020')->count();
        $D12 = Stock::where('model','Dell Vostro 230')->count();
        $D13 = Stock::where('model','Dell Vostro 270')->count();
        $D14 = Stock::where('model','HP Compaq M6200')->count();
        $laptop_year1 = Stock::whereBetween('purchase_date', ['2010-01-01', '2013-12-31'])->where('asset_id','6')->count();
        $laptop_year2 = Stock::whereBetween('purchase_date', ['2015-01-01', '2018-12-31'])->where('asset_id','6')->count();
        $laptop_year3 = Stock::whereBetween('purchase_date', ['2019-01-01', '2021-12-31'])->where('asset_id','6')->count();
        $laptop_year4 = Stock::whereBetween('purchase_date', ['2022-01-01', '2023-12-31'])->where('asset_id','6')->count();
        $laptop_year5 = Stock::whereBetween('purchase_date', ['2024-01-01', '2024-12-31'])->where('asset_id','6')->count();
        $totalStock = Stock::count();
        $monthlyTrends = [
            'labels' => [],
            'issued' => [],
            'returned' => []
        ];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyTrends['labels'][] = $date->format('M Y');
            $monthlyTrends['issued'][] = Issuance::whereYear('issuance_date', $date->year)
                ->whereMonth('issuance_date', $date->month)
                ->count();
            $monthlyTrends['returned'][] = Issuance::whereNotNull('return_date')
                ->whereYear('return_date', $date->year)
                ->whereMonth('return_date', $date->month)
                ->count();
        }
        $inStockCount = Stock::where('status', Stock::STATUS_IN_STOCK)->count();
        $issuedCount = Stock::where('status', Stock::STATUS_ISSUED)->count();
        $repairableCount = Stock::where('status', 'Repairable')->count();
        $deadCount = Stock::where('status', 'Dead')->count();
        $notReceivableCount = Stock::where('status', 'Not Receivable')->count();
        return view('dashboard', [
        'employee' => $employee,
        'laptop' => $laptop,
        'desktop' => $desktop,
        'printer' => $printer,
        'scanner' => $scanner,
        'allinone' => $allinone,
        'tablet' => $tablet,
        'server' => $server,
        'ap' => $AP,
        'nvr' => $NVR,
        'ns' => $NS,
        'led' => $LED,
        'd1' => $D1,
        'd2' => $D2,
        'd3' => $D3,
        'd4' => $D4,
        'd5' => $D5,
        'd6' => $D6,
        'd7' => $D7,
        'd8' => $D8,
        'd9' => $D9,
        'd10' => $D10,
        'd11' => $D11,
        'd12' => $D12,
        'd13' => $D13,
        'd14' => $D14,
        'laptop_year1' => $laptop_year1,
        'laptop_year2' => $laptop_year2,
        'laptop_year3' => $laptop_year3,
        'laptop_year4' => $laptop_year4,
        'laptop_year5' => $laptop_year5,
        'totalStock' => $totalStock,
        'inStockCount' => $inStockCount,
        'issuedCount' => $issuedCount,
        'repairableCount' => $repairableCount,
        'deadCount' => $deadCount,
        'notReceivableCount' => $notReceivableCount,
        'activeEmployees' => $activeEmployees,
        'departmentCount' => $departmentCount,
        'assetTypeCount' => $assetTypeCount,
        'pendingReturns' => $pendingReturns,
        'issuedThisMonth' => $issuedThisMonth,
        'returnedThisMonth' => $returnedThisMonth,
        'expiredCount' => $expiredCount,
        'expiringSoonCount' => $expiringSoonCount,
        'stockByType' => $stockByType,
        'issuedByDepartment' => $issuedByDepartment,
        'recentIssuances' => $recentIssuances,
        'recentReturns' => $recentReturns,
        'longestHeld'  => $longestHeld,
        'monthlyData'  => $monthlyData,
        'monthlyTrends' => $monthlyTrends,
    ]);


    }
}
