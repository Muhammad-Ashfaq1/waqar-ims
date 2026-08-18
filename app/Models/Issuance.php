<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issuance extends Model
{
    use HasFactory;

    function getStock(){
        return $this->belongsTo('App\Models\Stock', 'stock_id');
    }
    function getEmployee(){
        return $this->belongsTo('App\Models\Employee', 'employee_id');
    }


}
