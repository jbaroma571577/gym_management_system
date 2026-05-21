<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutPlan extends Model
{
    protected $fillable = [
        'member_id',
        'title',
        'program_type',
        'description',
        'goal',
        'start_date',
        'end_date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}