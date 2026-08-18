<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Employee;

class DashboardController extends Controller
{
    function DashboardValues(){
        $employee = Employee::select()->count();
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

    ]);


    }
}
