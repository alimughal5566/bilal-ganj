<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Wishlist extends Model
{
    protected $guarded=[
        'id','_token'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function saveWish($data)
    {

        $qry= Wishlist::create($data);
        return $qry;
    }
    public function deleteWish($id)
    {
        $qry = Wishlist::where('id',$id)->delete();

        return $qry;
    }
    public function countWishs(){
        $qry = Wishlist::where('user_id',Auth::user()->id)->count();
        return $qry;
    }

    public function specificUserWishes($id)
    {
        $wish= Wishlist::where('user_id',$id)->get();
        return $wish;
    }
}
