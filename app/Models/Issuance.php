<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Issuance extends Model
{
    use HasFactory;

    protected $casts = [
        'issuance_date' => 'date',
        'return_date' => 'date',
    ];

    function getStock(){
        return $this->belongsTo('App\Models\Stock', 'stock_id');
    }
    function getEmployee(){
        return $this->belongsTo('App\Models\Employee', 'employee_id');
    }

    public function getDaysHeldAttribute(): ?int
    {
        if (! $this->issuance_date) {
            return null;
        }

        $start = $this->issuance_date->copy()->startOfDay();
        $end = ($this->return_date ?: Carbon::today())->copy()->startOfDay();

        return (int) $start->diffInDays($end);
    }

    public function getHeldForAttribute(): string
    {
        if (! $this->issuance_date) {
            return '-';
        }

        $start = $this->issuance_date->copy()->startOfDay();
        $end = ($this->return_date ?: Carbon::today())->copy()->startOfDay();

        if ($end->lt($start)) {
            return '0 days';
        }

        $interval = $start->diff($end);
        $parts = [];

        if ($interval->y > 0) {
            $parts[] = $interval->y.'y';
        }

        if ($interval->m > 0) {
            $parts[] = $interval->m.'m';
        }

        if ($interval->d > 0 || $parts === []) {
            $parts[] = $interval->d.' '.($interval->d === 1 ? 'day' : 'days');
        }

        return implode(' ', $parts);
    }

    public function getHistoryStatusAttribute(): string
    {
        return $this->return_date ? 'Returned' : 'Issued';
    }
}
