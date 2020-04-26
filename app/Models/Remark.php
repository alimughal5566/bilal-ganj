<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Remark extends Model
{
    protected $guarded = [
        'id', '_token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bgShop()
    {
        return $this->belongsTo(BgShop::class);
    }

    public function saveRemark($vendor,$fromData){
        $qry = Remark::create([
           'user_id'=>Auth::user()->id,
           'bgShop_id'=>$vendor->id,
           'message'=>$fromData['message'],
           'latitude'=>$fromData['latitude'],
           'longitude'=>$fromData['longitude']
        ]);
        return $qry;
    }
}
