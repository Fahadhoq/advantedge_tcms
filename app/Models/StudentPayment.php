<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    use HasFactory;

    protected $table = "student_payments";

    protected $fillable = [
        'user_id',
        'payment_amount',
        'payment_type',
        'payment_date',
        'payment_mobile_number',
        'payment_transaction_number	',
        'cheque_transit_number',
        'payment_remark',
    ];
}
