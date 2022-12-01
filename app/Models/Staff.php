<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'staff_id';

    protected $guarded = [];

    // public function salary()
    // {
    //     return $this->hasOne(SetupSalary::class, 'staff_id');
    // }
}
