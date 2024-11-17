<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffEmailVerify extends Model
{
    use HasFactory;

    public $table = "staff_email_verify";

    protected $fillable = [
        'staff_id',
        'token',
    ];

    public function staff(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }
}
