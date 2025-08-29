<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'party_id',
        'amount',
        'payment_type',
        'total_amount',
        'paid_amount',
        'remainig_amount',
        'payment_note',
        'payment_date'
    ];
}
