<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'loan_payment_episodes';

    protected $primaryKey = 'loan_pay_id';

    protected $guarded = [];

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }
}
