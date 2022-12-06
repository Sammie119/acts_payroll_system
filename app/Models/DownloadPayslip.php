<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadPayslip extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function username()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
