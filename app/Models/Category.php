<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
class Category extends Model
{
    protected $table = 'categories';
    protected $guarded = [
        'id', '_token'
    ];
    public function products(){
        return $this->belongsToMany(Product::class,'categories_products','category_id','product_id');
    }

    public function addCategory($array)
    {
        $qry=Category::create($array);
        return $qry;
    }

    public function categoryfetch(){
        $qry = Category::all();
        return $qry;
    }
    public function categoriesView(){
        $bikes=Category::where('parent_id',4)->get();
        $cars =Category::where('parent_id',3)->take(6)->get();

        $honda =Category::where('parent_id',5)->take(4)->get();
        $suzuki=Category::where('parent_id',6)->take(4)->get();
        $united=Category::where('parent_id',7)->take(4)->get();
        $road  =Category::where('parent_id',8)->take(4)->get();
        $metro =Category::where('parent_id',9)->take(4)->get();
        $yamaha=Category::where('parent_id',10)->take(4)->get();

        $suzukiCar  =Category::where('parent_id',62)->take(4)->get();
        $toyotaCar  =Category::where('parent_id',63)->take(4)->get();
        $hondaCar   =Category::where('parent_id',64)->take(4)->get();
        $daihatsuCar=Category::where('parent_id',65)->take(4)->get();
        $nissanCar  =Category::where('parent_id',66)->take(4)->get();
        $audiCar    =Category::where('parent_id',67)->take(4)->get();

            $array=[
                'cars'=>$cars,
                'bikes'=>$bikes,

                'honda'=>$honda,
                'suzuki'=>$suzuki,
                'united'=>$united,
                'road'=>$road,
                'metro'=>$metro,
                'yamaha'=>$yamaha,

                'suzukiCar'=>$suzukiCar,
                'toyotaCar'=>$toyotaCar,
                'hondaCar'=>$hondaCar,
                'daihatsuCar'=>$daihatsuCar,
                'nissanCar'=>$nissanCar,
                'audiCar'=>$audiCar
                ];
        return $array;
    }

    public function sub_category()
    {
       return $this->belongsTo(self::class , 'parent_id','id');
    }
    public function categories()
    {
        return $this->hasMany(self::class, 'id','parent_id');
    }
    public function fetchCategory($category)
    {
        foreach ($category as $val){
            $categoryTest[] = Category::where('parent_id',$val)->get();
        }

        return $categoryTest;
    }
}
