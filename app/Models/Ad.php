<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{

    protected $guarded=[
        'id','_token'
    ];

    public function bgShop(){
        return $this->belongsTo(BgShop::class);
    }
    public function addsType()
    {
        return $this->belongsTo(AddsType::class);
    }
    public function adMedia(){
        return $this->hasMany(AdsMedia::class);
    }
    public function viewAds(){}
    public function addAds($adData){
        $data=Ad::create($adData);
        return $data;
    }
    public function displayAd(){
      $ad=Ad::all();
      return $ad;
    }
    public function fetchAd(){
    $count = Ad::where('status','approved')->count();
    if($count>0) {
        $qry = Ad::where('status', 'approved')->get();
        $adId = $qry->first()->id;
        return $adId;
    }
}
    public function deleteAds(){}
    public function getDiscount(){}

//    public function saveAds($formdata,$extension){
//        $qry = Ad::create(array_merge($formdata,['image'=>$extension]));
//        return $qry;
//    }
}
