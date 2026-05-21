<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'member_id',
        'date',
        'time_in',
        'time_out',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}