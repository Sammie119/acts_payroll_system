<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VWStaff extends Model
{
    use HasFactory;

    protected $table = 'vw_staff';

    public function pay_staff()
    {
        return $this->hasMany(Payroll::class, 'staff_id', 'staff_id');
    }

    public function pay_depend_on()
    {
        return $this->hasMany(PayrollDependecy::class, 'staff_id', 'staff_id');
    }
}
