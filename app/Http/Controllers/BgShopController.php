<?php

namespace App\Http\Controllers;

use App\Models\BgShop;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BgShopController extends Controller
{
    public function vendorPanel($id=null)
    {
        if ($id) {
            $obj = new BgShop();
            $vendor = $obj->fetchSpecificVendor($id);
            return view('vendor.home', compact('vendor'));
        } else {
            return view('vendor.home');
        }
    }

    public function vendorPassword()
    {
        return view('vendor.change-password');

    }
    public function viewProducts($id)
    {
        $bg_shop = new BgShop();
        $bg_id = $bg_shop->findId($id);
        $tId=$bg_id->id;
        $product = new Product();
        $collect = $product->vendorProducts($tId);
        $vendor = $bg_shop->fetchSpecificVendor($id);
        return view('vendor.all-products', compact('collect','vendor'));

    }

    public function responseToFeedback($notification=null)
    {
        $notify = Notification::find($notification);
        Notification::where('id',$notification)->first()->update(['status'=>1]);
        $type = $notify['type'];

        switch ($type) {
            case 'feedback':
                return redirect()->route('productDetail',['id'=>$notification]);
                break;
            default:
                return redirect()->back();
                break;
        }
    }
}
