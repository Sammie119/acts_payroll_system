<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PayrollDependecy extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'loan_ids' => 'array',
        'incomes' => 'array',
        'deductions' => 'array',
        'amount_incomes' => 'array',
        'amount_deductions' => 'array',
        'rate_incomes' => 'array',
        'rate_deductions' => 'array'
    ];

    public function pay_staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
