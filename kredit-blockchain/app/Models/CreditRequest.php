<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditRequest extends Model
{
    protected $fillable = ['user_address', 'amount', 'approved', 'paid'];
}
