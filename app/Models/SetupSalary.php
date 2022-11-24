<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SetupSalary extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'salary_id';

    protected $guarded = [];

    public function staff()
    {
        return $this->belongsTo(VWStaff::class, 'staff_id', 'staff_id');
    }
}
