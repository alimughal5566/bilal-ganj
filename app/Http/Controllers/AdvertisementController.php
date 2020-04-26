<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AddsType;
use App\Models\AdsMedia;
use App\Models\BgShop;
//use Faker\Provider\Image;
use App\Models\Credit;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class AdvertisementController extends Controller
{
    public function adDetailView()
    {
        return view('admin.addsdetail');
    }

    public function saveAdDetail(Request $request)
    {
        $formData = $request->all();

        $this->validate($request, [
            'type' => 'required',
            'credits' => 'required',
            'duration' => 'required',
            'size' => 'required',
        ]);
        $ad = new AddsType();
        $result = $ad->saveType($formData);
        if ($result) {
            Session::flash('success', 'Advertisment Info Saved Successfully');
            return redirect()->back();
        }
    }

    public function addsIndex($id)
    {
        $obj = new BgShop();
        $obj2 = new AddsType();
        $vendor = $obj->fetchSpecificVendor($id);
        $adtypes = $obj2->fetchAll();
        return view('vendor.adds-index', compact('vendor', 'adtypes'));
    }

    public function postAdsView($id, $type_id)
    {
        $obj = new BgShop();
        $vendor = $obj->fetchSpecificVendor($id);
        $obj2 = new AddsType();
        $typeDetail = $obj2->specificType($type_id);
        return view('vendor.adds-form', compact('vendor', 'typeDetail'));

    }

    public function saveAds(Request $request)
    {
        $formdata = $request->all();
        $this->validate($request, [
            'title' => 'required|min:5|max:30',
            'description' => 'required|max:30',
            'credits' => 'required|numeric|min:1',
//             'duration' => 'required',
        ]);

        if ($request->photoLeadboard || $request->photoSlot1 || $request->photoSlot2) {
            $image = $request->only('photoLeadboard' , 'photoSlot1' , 'photoSlot2');
                    $obj = new BgShop();
                    $vendor = $obj->fetchVendorByShopID($request->bgshop_id);
                    if (($vendor->credit) >= ($request->credits)) {
                    $credits = $request->credits;
                    $obj3 = BgShop::where('user_id',$vendor->user_id) ->decrement('credit', (int)$credits);

                    $ad = new Ad();
                    $adData = $request->only('title', 'description', 'bgshop_id', 'credits');
                    $data = $ad->addAds($adData);

                foreach ($image as $img) {
                    $type = "";
                    if ($img == $request->photoLeadboard) {
                        $type = "banner";
                    } elseif ($img == $request->photoSlot1) {
                        $type = "slot1";
                    } elseif ($img == $request->photoSlot2) {
                        $type = "slot2";
                    }

                    $str = explode('/',$img);
//                    dd($str);
// explode()
                    $extension = explode(';',$str[1]);
                    $image = str_replace('data:image/'.$extension[0].';base64,', '', $img);



//                    $img = str_replace('data:image/png;base64,', '', $img);
                    $img = str_replace(' ', '+', $image);
                    $imageName = str_random(10) . '.' . 'png';
                    $imgData = base64_decode($img);

                    \Illuminate\Support\Facades\File::put(public_path() . '/assets/ads-images/' . $imageName, $imgData);
                    $adMedia = new AdsMedia();
                    $adimage = [
                        'image' => $imageName,
                        'ad_id' => $data['id'],
                        'type'  => $type
                    ];
//                    dd($type);
                    $image = $adMedia->saveAdImage($adimage);
                }
            }
            else
            {
                Session::flash('request', 'Your credit points are not sufficient to buy this add. Please buy some credit points first');
                return redirect()->back()->withInput();
            }

            if ($image && $data) {
                Session::flash('request', 'Ad request send to admin');
                return redirect()->back();
            }
            else
            {
                session()->flash('message','Fail to send request');
                return redirect()->back()->withInput();
            }
        }
    }
}
