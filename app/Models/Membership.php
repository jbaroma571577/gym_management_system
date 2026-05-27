<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
        'member_id',
        'plan',
        'status',
        'payment_method',
        'reference_number',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public static function planDetails(): array
    {
        return [
            'Basic' => [
                'price' => 500.00,
                'duration_days' => 30,
                'daily_limit' => 1,
                'label' => 'Basic',
                'badge_class' => 'bg-slate-600/15 text-slate-200',
                'dashboard_class' => 'border-slate-500/20 text-slate-200',
                'description' => 'Access to gym equipment only, one check-in per day, and basic workout plans.',
                'features' => [
                    'Access to gym equipment only',
                    '1 attendance/check-in per day',
                    'No trainer access',
                    'No group classes',
                    'Basic workout plans only',
                ],
                'dashboard_level' => 'Basic dashboard view',
            ],
            'Premium' => [
                'price' => 800.00,
                'duration_days' => 60,
                'daily_limit' => null,
                'label' => 'Premium',
                'badge_class' => 'bg-sky-500/15 text-sky-300',
                'dashboard_class' => 'border-sky-500/20 text-sky-300',
                'description' => 'Full gym access, unlimited attendance, group classes, and premium workout plans.',
                'features' => [
                    'Full gym equipment access',
                    'Unlimited attendance/check-ins',
                    'Access to group classes',
                    'Access to workout plans',
                    'Trainer booking 2 times per month',
                    'Priority support',
                ],
                'dashboard_level' => 'Premium dashboard features',
            ],
            'VIP' => [
                'price' => 1200.00,
                'duration_days' => 90,
                'daily_limit' => null,
                'label' => 'VIP',
                'badge_class' => 'bg-yellow-400/15 text-yellow-300',
                'dashboard_class' => 'border-yellow-400/20 text-yellow-300',
                'description' => 'Unlimited full access, personalized plans, VIP lounge, and exclusive features.',
                'features' => [
                    'Unlimited full access to all gym facilities',
                    'Unlimited attendance and trainer sessions',
                    'Access to VIP locker/lounge',
                    'Personalized workout and nutrition plans',
                    'Priority booking for classes',
                    'Full premium dashboard and exclusive features',
                ],
                'dashboard_level' => 'VIP dashboard and exclusive benefits',
            ],
        ];
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function isActiveWithValidity(): bool
    {
        return $this->status === 'active' && ! $this->isExpired();
    }

    public function getPlanInfo(): array
    {
        return self::planDetails()[$this->plan] ?? [];
    }

    public function getBadgeClass(): string
    {
        return $this->getPlanInfo()['badge_class'] ?? 'bg-slate-500/15 text-slate-300';
    }

    public function getDashboardClass(): string
    {
        return $this->getPlanInfo()['dashboard_class'] ?? 'border-orange-500/20 text-orange-300';
    }

    public function getDailyLimit(): ?int
    {
        return $this->getPlanInfo()['daily_limit'] ?? null;
    }

    public function getDurationDays(): int
    {
        return $this->getPlanInfo()['duration_days'] ?? 30;
    }

    public function getDescription(): string
    {
        return $this->getPlanInfo()['description'] ?? 'A gym membership plan.';
    }

    public function getFeatures(): array
    {
        return $this->getPlanInfo()['features'] ?? [];
    }

    public function canBookTrainers(): bool
    {
        return in_array($this->plan, ['Premium', 'VIP']);
    }

    public function canAccessGroupClasses(): bool
    {
        return in_array($this->plan, ['Premium', 'VIP']);
    }

    public function hasVipAccess(): bool
    {
        return $this->plan === 'VIP';
    }
}
