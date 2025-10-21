<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanPaymentCompletion extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

    public function staff()
    {
        return $this->belongsTo(VWStaff::class, 'staff_id', 'staff_id');
    }
}
