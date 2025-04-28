<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'duration',
        'interest_rate',
        'start_month',
        'start_year',
        'end_month',
        'end_year',
        'status',
        'document_path',
        'total_payment',
    ];

    /**
     * Define the relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'loan_application_id');
    }

    public function getRemainingAmountAttribute()
    {
        return $this->total_payment - $this->payments->sum('amount');
    }
}
