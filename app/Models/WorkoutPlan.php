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

    public static function allowedProgramsForMembership(string $plan): array
    {
        $programs = [
            'Fat Loss Program',
            'Muscle Building Program',
            'Body Recomposition Program',
            'Health and Endurance Program',
            'Discipline and Lifestyle Change Program',
        ];

        switch ($plan) {
            case 'VIP':
                return $programs;
            case 'Premium':
                return [
                    'Fat Loss Program',
                    'Muscle Building Program',
                    'Body Recomposition Program',
                    'Health and Endurance Program',
                ];
            case 'Basic':
            default:
                return [
                    'Fat Loss Program',
                    'Muscle Building Program',
                    'Body Recomposition Program',
                ];
        }
    }

    public function scopeForMembershipPlan($query, ?string $plan)
    {
        if (! $plan) {
            return $query;
        }

        return $query->whereIn('program_type', self::allowedProgramsForMembership($plan));
    }
}
