<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'goal',
        'trainer_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function membership()
    {
        return $this->hasOne(Membership::class)->latestOfMany();
    }

    public function workoutPlan()
    {
        return $this->hasOne(WorkoutPlan::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}