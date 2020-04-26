<?php
/**
 * Created by PhpStorm.
 * User: bc140403104
 * Date: 5/4/2019
 * Time: 12:28 PM
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAccountController extends Controller
{
    public function adminChangePassword(Request $request)
    {
        $formdata = $request->all();
        $this->validate($request, [
            'old_password' => 'required|min:5',
            'password' => 'required|min:5',
        ]);
        $user = new User();
        $updatedPassword = $user->updateAdminPassword($formdata);
        if ($updatedPassword) {
            Session::flash('success', 'Password changed successfully');
            return redirect()->back();
        } else {
            return redirect()->back()->with(['error' => "Password doesn't matched"]);
        }
    }

    public function editAdminProfile(Request $request)
    {
        $formdata = $request->all();
        $this->validate($request, [
            'address' => 'required',
            'contact_number' => 'required|digits:11|numeric',
        ]);
        $user = new User();
        $updatedAdmin = $user->updateAdminProfile($formdata);
        if ($updatedAdmin) {
            Session::flash('success', 'Your Profile is Successfully Updated');
            return redirect()->back();
        }
    }
}