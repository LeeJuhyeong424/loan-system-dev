<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'interest_rate', 'status', 'paid_amount', 'start_date', 'end_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRemainingAttribute()
    {
        return $this->amount - $this->paid_amount;
    }

    public function getMonthlyInterestAttribute()
    {
        return floor(($this->amount * $this->interest_rate) / 100 / 12);
    }
}
