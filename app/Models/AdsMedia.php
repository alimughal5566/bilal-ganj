<?php
/**
 * Created by PhpStorm.
 * User: bc140403104
 * Date: 8/1/2019
 * Time: 8:07 PM
 */

namespace App\Models;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\Auth;
use Auth;



class AdsMedia extends Model
{
    protected $guarded=[
        'id','_token'
    ];
public function ads(){
    return $this->belongsTo(Ad::class);
}
public function saveAdImage($adimage ){
    $qry = AdsMedia::create($adimage);

    $admin=User::all()->where('type','admin')->first();
    $bgshop=User::all()->where('type','bgshop')->first();
    if($admin){
        Notification::create([
            'user_id' => $admin->id,
            'message' => "New vendor $bgshop->name Ad request received",
            'type'=>'approveAd',
        ]);
    }
    return $qry;
}
    public function fetchAdBanner()
    {
        $count = Ad::where('status','approved')->count();
        if($count>0) {
            $qry = AdsMedia::where('type', 'banner')->inRandomOrder()->get()->first();
            return $qry;
        }
    }
    public function fetchAdSlot1()
    {
        $count = Ad::where('status','approved')->count();
        if($count>0) {
            $qry = AdsMedia::where('type', 'slot1')->inRandomOrder()->first();
            return $qry;
        }
    }
    public function fetchAdSlot2()
    {
        $count = Ad::where('status','approved')->count();
        if($count>0) {
            $qry = AdsMedia::where('type', 'slot2')->inRandomOrder()->first();
            return $qry;
        }
    }

}
