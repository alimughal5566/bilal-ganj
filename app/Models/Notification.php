<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded=[
        'id','_token'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function notify($user_id, $message, $type=null){
        $qry = Notification::create([
           'user_id'=>$user_id,
           'message'=>$message,
           'type'=>$type,
        ]);
        return $qry;
    }

    public function sendNotification(){}
    public function readNotification(){}

}
