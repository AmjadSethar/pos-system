<?php

namespace App\Models;

use App\Models\Party\Party;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'party_id',
        'amount',
        'payment_type',
        'payment_note',
        'payment_date'
    ];


    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id', 'id');
    }

}
