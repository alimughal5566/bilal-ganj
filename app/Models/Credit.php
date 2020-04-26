<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Credit extends Model
{
    protected $guarded = [
        'id', '_token'
    ];
    public function bgShop(){
        return $this->belongsTo(BgShop::class);
    }
    public function calculateAmount(){}

    public function getNoOfTranscation(){}

    public function updateCredit($credit , $id)
    {
        $qry = BgShop::where('user_id', $id)->update(['credit' => $credit]);
        return $qry;
    }
    public function saveCredit($payment , $credit)
    {
        $qry2 = Credit::create(['bgshop_id' => $payment['vendor_id'], 'amount' => $payment['amount'] , 'credits'=> $credit]);
        return $qry2;
    }
    public function fetch($id)
    {
        $qry = Credit::where('bgshop_id', $id)->orderBy('created_at' , 'DESC')->get();
        return $qry;
    }
}
