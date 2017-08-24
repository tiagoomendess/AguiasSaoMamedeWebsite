<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use MongoDB\BSON\Timestamp;

class Payment extends Model
{
    protected $fillable = ['date', 'method', 'description', 'amount', 'deleted'];

    public static function make($method, $description, $amount) {

        $payment = Payment::create([
            'method' => $method,
            'description' => $description,
            'amount' => $amount,
        ]);

        return $payment;
    }
}
