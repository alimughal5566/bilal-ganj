<?php

namespace App\Http\Controllers;

use App\Models\AdsMedia;
use App\Models\Ad;
use App\Models\BgShop;
use App\Models\Cart;
use App\Models\Package;
use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     *
     */
    public function checkVendorsCredit()
    {
        $obj = BgShop::all();
        $count = $obj->count();

        for ($i=0 ; $i<$count ; $i++)
        {
            if($obj[$i]->credit <=0)
            {
                $obj2 = new Product();
                $id = $obj[$i]->id;
                $user_id = $obj[$i]->user_id;
                $notVisible = $obj2->changeProductVisibility($id , $user_id);
            }
        }
    }
    public function index()
    {
        $this->checkVendorsCredit();
        $obj = new Product();
        $ad= new Ad();
        $allAds=$ad->fetchAd();
//        $addsImg =AdsMedia::where('ad_id',$allAds)->inRandomOrder()->first();
        $addsImg = new AdsMedia();
        $banner = $addsImg->fetchAdBanner();
        $slot1 = $addsImg->fetchAdSlot1();
        $slot2 = $addsImg->fetchAdSlot1();

        $allProducts = $obj->fetchProducts();
        $category    = new Category();
        $categories  = $category->categoriesView();
        $bikes       = $categories['bikes'];
        $cars        = $categories['cars'];

        $honda  = $categories['honda'];
        $suzuki = $categories['suzuki'];
        $united = $categories['united'];
        $road   = $categories['road'];
        $metro  = $categories['metro'];
        $yamaha = $categories['yamaha'];

        $suzukiCar   = $categories['suzukiCar'];
        $toyotaCar   = $categories['toyotaCar'];
        $hondaCar    = $categories['hondaCar'];
        $daihatsuCar = $categories['daihatsuCar'];
        $nissanCar   = $categories['nissanCar'];
        $audiCar     = $categories['audiCar'];
//        dd($img);

        return view('home.home', compact('allProducts','categories','bikes','honda','suzuki','united','road','metro','yamaha','cars','suzukiCar','toyotaCar','hondaCar','daihatsuCar','nissanCar','audiCar','banner' , 'slot1' , 'slot2' , 'allAds'));

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shop()
    {
        $obj = new Product();
        $products = $obj->fetchPaginateProducts();
        $allProducts = $obj->fetchProducts();
        $shop = new BgShop();
        $manufactures = $shop->fetchVendors();
        return view('home.shop', compact('products', 'allProducts', 'manufactures'));

    }

    public function selectCat($id){
        $obj = new Product();
        $category = Category::find($id);
        $products = $obj->fetchSpecificProducts($category);
        $allProducts = $products;
        $sortHide = true;
        $shop = new BgShop();

        $manufactures = $shop->fetchVendors();
        return view('home.shop',compact('products','allProducts','sortHide','manufactures'));
    }

    public function aboutUs()
    {
        return view('home.about');
    }

    public function contactUs()
    {

        return view('home.contact');

    }

    public function wishList()
    {
        return view('home.wishlist');
    }

    public function productDetail($id = null)
    {
        $obj = new Product();
        $product = $obj->fetchSingleProduct($id);

        $previous = $obj->fetchPreviousProduct($id);

        $next = $obj->fetchNextProduct($id);
        $comment = $obj->getFeedback($product->id);
        $amount = $product->ucp;
        $amount += $amount / 100 * $product->discount;
        $allProducts = $obj->fetchRelatedProducts($product);
        $flag=true;

        return view('home.product-detail', compact('flag','allProducts','product', 'previous', 'next','amount', 'comment'));
    }
    public function ruf(Request $request){

    }
}
