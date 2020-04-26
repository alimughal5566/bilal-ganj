<?php


namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    public function packageFormView()
    {
        return view('admin.addsdetail');
    }
    public function savePackage(Request $request)
    {
        $formData = $request->all();
        $this->validate($request, [
            'type'=>'required | unique:packages',
            'min_time'=>'required',
            'banner_price'=>'required|numeric',
            'slot1_price'=>'required|numeric',
            'slot2_price'=>'required|numeric',
        ]);
        $obj = new Package();
        $result = $obj->savePackage($formData);
        if($result)
        {
            return redirect()->back();
        }
        return redirect()->back()->withInput();
    }
    public function editPackage(Request $request)
    {

    }

}
