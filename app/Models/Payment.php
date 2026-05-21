<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'membership_id',
        'amount',
        'reference_number',
        'status',
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}

