<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'loan_application_id', 'amount', 'payment_date', 'status', 'installment_month',];

    // Pastikan kolom payment_date di-cast menjadi objek Carbon
    protected $casts = [
        'payment_date' => 'datetime',
    ];

    public function loan()
    {
        return $this->belongsTo(LoanApplication::class, 'loan_application_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}