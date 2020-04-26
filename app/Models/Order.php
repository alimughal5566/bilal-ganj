<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    protected $guarded = [
        'id', '_token'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function cart(){
        return $this->belongsTo(Cart::class);
    }

    public function riderLog(){
        return $this->hasMany(RiderLog::class);
    }

    public function calculateDateTime($cart, $request, $time, $flag=null){
        if($flag == true) {
            dd('1');
            $explode = $time;
            $estimatedTime = date('Y-m-d H:i:s', mktime(0, $explode * 30));
        }

        else
            {
            $explode = explode(' ', $time);
            $estimatedTime = date('Y-m-d H:i:s', mktime(0, $explode[0] * 30));
        }
        $nextDate = date('Y-m-d H:i:s', strtotime($estimatedTime . ' +1 day'));
        date_default_timezone_set('Asia/Dubai');
        $today = time();
        $date = date("H:i:s", $today);
        $hour = explode(':', $date);
        $orderObj = new Order();
        $id = Auth::user()->id;
        if ($hour[0] >= 18 && $hour[0] <= 23)
        {
            if ($flag == true){
//                dd('nextDate '.$nextDate);
                Order::where('cart_id',$cart->id)->update([
                    'estimated_time'  => $nextDate
                ]);
            }else{
                $orderObj->saveOrder($id, $cart->id, $request->total, $nextDate);
            }
        } else {
            if ($flag == true){
                Order::where('cart_id',$cart->id)->update([
                    'estimated_time'  => $estimatedTime
                ]);
            }else {
                $orderObj->saveOrder($id, $cart->id, $request->total, $estimatedTime);
            }
        }
    }

    public function saveOrder($id, $cartId, $total, $date){
        $qry = Order::create([
            'user_id' => $id,
            'cart_id' => $cartId,
            'status' => 'pending',
            'amount' => $total,
            'estimated_time' => $date,
        ]);
        return $qry;
    }


    public function doOrder(){}
    public function cancelOrder(){}
    public function updateOrder(){}
    public function responseToOrder(){}
}
