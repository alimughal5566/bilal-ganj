<?php
/**
 * Created by PhpStorm.
 * User: MUHAMMAD ALI
 * Date: 5/7/2019
 * Time: 10:40 PM
 */

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\BgShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BgShopAccountController extends Controller
{
public function editVendorProfile(Request $request){
    $formdata = $request->all();

    $this->validate($request,[
        'name' => 'required',
        'shop_name' => 'required|min:3|max:30',
        'contact_number' => 'required|digits:11|numeric',
        'email' => 'required|email',
        'address' => 'required'

    ]);
    $userTableAttr=$request->only('name','address','contact_number','email');
    $user =new User();
    $updatedUser = $user->updatedVendorProfile($userTableAttr);

    $bgshop=new BgShop();
    $array=[
        'user_id'=>$formdata['user_id'],
        'shop_name'=>$formdata['shop_name']
    ];
    $updatedVendor=$bgshop->updateBgShop($array);
    if ($updatedVendor && $updatedUser) {
        Session::flash('success', 'Your Profile is Successfully Updated');
        return redirect()->back();
    }
}
public function editVendorPassword(Request $request){
    $formdata=$request->all();
    $this->validate($request, [
        'old_password' => 'required|min:5',
        'password' => 'required|min:5',
    ]);
    $user = new User();
    $updatedVendor = $user->updatedVendorPassword($formdata);
    if($updatedVendor) {
        Session::flash('success', 'Password changed successfully');
        return redirect()->back();
    }
    else{
        return redirect()->back()->with(['error'=>"Password doesn't matched"]);
    }
}
}