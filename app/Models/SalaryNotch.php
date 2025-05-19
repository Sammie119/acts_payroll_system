<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryNotch extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function grade()
    {
        return $this->belongsTo(SalaryGrade::class, 'salary_grade_id');
    }
}
