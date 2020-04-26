<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [
        'id', '_token'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function savePayment($payment)
    {
        $qry = Payment::create(['user_id' => $payment['user_id'], 'amount' => $payment['amount']]);

        return  $qry;
    }
    public function fetch($id)
    {
        $qry = Payment::where('user_id', $id)->orderBy('created_at' , 'DESC')->get();
        return $qry;
    }
}
