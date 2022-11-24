<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payroll extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payroll_episodes';

    protected $primaryKey = 'pay_id';

    protected $guarded = [];
    
    protected $casts = [
        'income' => 'array',
        'deduction' => 'array'
    ];
}
