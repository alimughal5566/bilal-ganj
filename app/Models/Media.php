<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;
    protected $guarded = [
        'id', '_token'
    ];

    public function products(){
        return $this->belongsTo(Product::class);
    }
    public function saveimage($array){
        $qry = Media::create($array);
        return $qry;
    }
    public function fetchImage(){
        $qry = Media::all();
        return $qry;
    }
}
