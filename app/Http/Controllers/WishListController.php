<?php
/**
 * Created by PhpStorm.
 * User: munaz
 * Date: 5/19/2019
 * Time: 11:17 AM
 */

namespace App\Http\Controllers;


use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class wishListController extends Controller
{
    public function wishlistView($id=null)
    {
        $wish= new  Wishlist();
        $allWhishs = $wish->specificUserWishes($id);
        return view('home.wishlist',compact('allWhishs'));
    }
    public function saveWish(Request $request)
    {
        $user = $request->user_id;
        $product = $request->product_id;
        $checkWish = DB::table('wishlists')->where(['user_id'=>$user , 'product_id'=>$product])->first();
        if(!$checkWish) {
            $data = $request->all();
            $wishObj = new Wishlist();
            $Wish =  $wishObj->saveWish($data);
            $count = $wishObj->countWishs();
        }
        return $count;
    }
    public function deleteWish(Request $request)
    {
        $wishObj = new Wishlist();
        $result = $wishObj->deleteWish($request->id);
        if ($result)
        {
            $count = $wishObj->countWishs();
        }
        return $count;
    }
}
