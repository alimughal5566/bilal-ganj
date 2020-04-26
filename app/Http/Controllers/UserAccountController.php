<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserAccountController extends Controller
{
    public function userAccount(){
        $orders =Order::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->get();
        return view('user-account.account',compact('orders'));
    }

    public function editProfile(Request $request){
        $formdata = $request->all();
        $this->validate($request,[
            'address' => 'required',
            'contact_number' => 'required|digits:11|numeric'
        ]);
        $user = new User();
        $updatedUser = $user->updateUser($formdata);
        if($updatedUser){
            Session::flash('success','Your Profile is Successfully Updated');
            return redirect()->back();
        }
    }

    public function changePassword(Request $request){

        $formdata =$request->all();

        $this->validate($request, [
            'old_password' => 'required|min:5',
            'password' => 'required|min:5',
        ]);
        $user = new User();
        $updatedUser = $user->updatePassword($formdata);

        if($updatedUser) {
            Session::flash('success', 'Password changed successfully');
            return redirect()->back();
        }
        else{
            return redirect()->back()->with(['error'=>"Password doesn't matched"]);
        }

    }
}
