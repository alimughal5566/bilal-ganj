<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model

{
    protected $guarded = [
        'id', '_token'
    ];
    public function adds()
    {
        return $this->belongsToMany(Ad::class);
    }
    public function savePackage($array)
    {
        $qry = Package::create($array);
        return $qry;
    }
    public function fetchAllPackage()
    {
        $qry = Package :: all();
//        dd($qry);
        return $qry;
    }
    public function fetchPack($package_id)
    {
        $qry = Package :: where('id' , $package_id)->first();
        return $qry;
    }
}
