<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'loan_episodes';

    protected $primaryKey = 'loan_id';

    protected $guarded = [];

    public function staff()
    {
        return $this->belongsTo(VWStaff::class, 'staff_id', 'staff_id');
    }

    public function loan_pay()
    {
        return $this->hasMany(LoanPayment::class, 'loan_id');
    }
}
