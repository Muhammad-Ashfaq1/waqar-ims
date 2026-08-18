<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    function getAsset(){
        return $this->belongsTo('App\Models\Asset', 'asset_id');
    }


    const STATUS_IN_STOCK = 'In Stock';
    const STATUS_ISSUED = 'Issued';
}
