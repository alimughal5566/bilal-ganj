<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Review extends Model
{
    protected $guarded = [
        'id', '_token'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function bgshop(){
        return $this->belongsTo(BgShop::class);
    }

    public function addReviews(){}
}
