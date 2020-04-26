<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddsType extends Model
{
    protected $guarded=[
        'id','_token'
    ];
    public function Adds()
    {
        return $this->belongsToMany(Ad::class);
    }

    public function saveType($formdata)
    {
        $qry = AddsType::create($formdata);
        return $qry;
    }
    public function fetchAll()
    {
        $qry =  AddsType::all();
        return $qry;
    }
    public function specificType($id)
    {
        $qry = AddsType::where('id',$id)->first();
        return $qry;
    }
}
