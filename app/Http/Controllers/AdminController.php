<?php
/**
 * Created by PhpStorm.
 * User: soft
 * Date: 02-May-19
 * Time: 11:19 AM
 */

namespace App\Http\Controllers;


use App\Models\Ad;
use App\Models\AdsMedia;
use App\Models\Agent;
use App\Models\BgShop;
use App\Models\Feedback;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\Remark;
use App\Models\Rider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function display()
    {
        $count_user = User::all()->where('type', 'user')->count();
        $count_product = Product::all()->count();
        $count_comment = Feedback::all()->count();
        $count_order = Order::all()->count();

        $user = new User();
        $allUsers = $user->fetchUsers();
        $time = User::latest('updated_at')->first();

        $arr = [
            'total_user' => $count_user,
            'total_product' => $count_product,
            'total_comment' => $count_comment,
            'total_order' => $count_order
        ];

        return view('admin.admin', compact('arr', 'allUsers', 'time'));
    }

    public function view()
    {
        $agent = new Agent();
        $allAgent = $agent->displayAll();
        $time = Agent::latest('updated_at')->first();
        return view('admin.agent-window', compact('allAgent', 'time'));
    }

    public function productList()
    {
        $products = Product::withTrashed()->get();
        $time = Product::latest('updated_at')->first();
        return view('admin.product-list', compact('products', 'time'));
    }

    public function viewRiders()
    {
        $rider = new Rider();
        $riders = $rider->fetchRiders();
        $time = Rider::latest('updated_at')->first();
        return view('admin.rider-window', compact('riders', 'time'));
    }

    public function creatFrom()
    {
        return view('admin.add-agent');
    }

    public function addRiderView()
    {
        return view('admin.add-rider');
    }

    public function fetchAgentVender()
    {
        $agent = new Agent();
        $allAgent = $agent->displayAgent();
        $vender = new BgShop();
        $allVender = $vender->displayVender();
        return view('admin.assign-agent', compact('allAgent', 'allVender'));
    }
    public function fetchAdDetail(){
       $ad= new Ad();
       $allAd=$ad->displayAd();
        $time = Ad::latest('updated_at')->first();
       return view('admin.ad-list',compact('allAd','time'));
    }
    public function approveAd($id){
        $ad=Ad::find($id);
        $adMedia=$ad->adMedia()->get();
//        dd($adMedia);
        $ad->status = 'approved';
        $vendor = BgShop::find($ad->bgshop_id);
        $userId = $vendor->user()->first()->id;
        $userName=$vendor->user()->first()->name;

       $adSave= $ad->save();
       if($adSave){
           Notification::create([
               'user_id' => $userId,
               'message' => "vendor $userName your request is approved",

           ]);
       }

        return redirect()->back();

    }
    public function rejectAd($id){
        $ad=Ad::find($id);
        $ad->status = 'rejected';
        $adSave= $ad->save();

        return redirect()->back();

    }

    public function responseToNotification($notification = null)
    {
        $notify = Notification::find($notification);
        Notification::where('id', $notification)->first()->update(['status' => 1]);
        $type = $notify['type'];

        switch ($type) {
            case 'assign':
                return redirect()->route('fetchAgentVender');
                break;
            case 'approveAd':
                return redirect()->route('fetchAdDetail');
                break;
            case 'verifyAccount':
                $bgShop = new BgShop();
                try {
                    $vendor = $bgShop->fetchSpecificVendor($notify['target_id']);
                    $remarks = Remark::where('bgShop_id', $vendor->id)->get();
                    $currentLocation = Remark::where('bgShop_id', $vendor->id)->orderBy('created_at', 'desc')->first();
                    return view('admin.verify-vendor', compact('vendor', 'remarks', 'currentLocation'));
                }catch (\Exception $e){
                    $vendor =  $remarks =  $currentLocation = null;
                    return view('admin.verify-vendor', compact('vendor', 'remarks', 'currentLocation'));
                }
                break;
            case 'rejectAccount':
                $bgShop = new BgShop();
                $vendor = $bgShop->fetchSpecificVendor($notify['target_id']);
                return view('admin.verify-vendor', compact('vendor'));
                break;
            default:
                return redirect()->back();
                break;
        }
//        if($id===null){
//            return redirect()->back();
//        }else{
//            $bgShop = new BgShop();
//            $vendor = $bgShop->fetchSpecificVendor($id);
//            return view('admin.verify-vendor',compact('vendor'));
//        }

    }

    public function assignAgentVender(Request $request)
    {
        $formdata = $request->all();
        $this->validate($request, [
            'agent' => 'required',
            'venders' => 'required'
        ]);
        $agentId = $request->input('agent');
        $venders = $request->input('venders');
        $imgval = count($request->input('venders'));
        $agent = new BgShop();
        $agent = $agent->assignAgentVender($agentId, $venders, $imgval);
        if ($agent) {
            Session::flash('agentassign', 'Agent Assign to Vendor Successfully');
            return redirect()->back();
        }
    }

    public function unassignAgentVender($id){
        $bgShop = new BgShop();
        $vendor = $bgShop->fetchAssignedVendor($id);
        return back();
    }

    public function changeStatus($id)
    {
        $bgShop = new BgShop();
        $vendor = $bgShop->fetchSpecificVendor($id);
        $agent = $vendor->agent()->first()->id;
        $user = $vendor->user()->first();
        $obj = new User();
        $updatedUser = $obj->updateStatus($user);
        if ($updatedUser) {
            Session::flash('verifyMes', 'Vendor is Verifed');
            return redirect()->back();
        }
    }

    public function fetchVendor()
    {
        $user = new BgShop();
        $vendors = $user->displayVender();
        $time = BgShop::latest('updated_at')->first();
        return view('admin.vendor-tab', compact('vendors', 'time'));
    }

    public function fetchUser()
    {
        $user = new User();
        $users = $user->fetchUserType();
        $time = User::latest('updated_at')->first();
        return view('admin.users-list', compact('users', 'time'));
    }

    public function statusActive(Request $request)
    {
        $id = $request->user_id;
        $obj = new User();
        $user = $obj->fetchSpecificUser($id);
        $type = $user->type;
        if ($user->deleted_at === null) {
            switch ($type) {
                case 'user':
                    $user->update(['is_active' => 'no']);
                    $user->delete();
                    break;
                case 'bgshop':
                    $user->update(['is_active' => 'no']);
                    $bgShop = $user->bgShop()->first();
                    $bgShop->delete();
                    $user->delete();
                    break;
                case 'agent':
                    $user->update(['is_active' => 'no']);
                    $agent = $user->agent()->first();
                    $agent->delete();
                    $user->delete();
                    break;
                case 'rider':
                    $user->update(['is_active' => 'no']);
                    $rider = $user->rider()->first();
                    $rider->delete();
                    $user->delete();
                    break;
            }
            return ['is_active' => 'No', 'status' => 'Blocked'];
        } else {
            switch ($type) {
                case 'user':
                    $user->restore();
                    $user->update(['is_active' => 'Yes']);
                    break;
                case 'bgshop':
                    $user->restore();
                    $user->bgShop()->restore();
                    $user->update(['is_active' => 'Yes']);
                    break;
                case 'agent':
                    $user->restore();
                    $user->agent()->restore();
                    $user->update(['is_active' => 'Yes']);
                    break;
                case 'rider':
                    $user->restore();
                    $user->rider()->restore();
                    $user->update(['is_active' => 'Yes']);
                    break;
            }
            return ['is_active' => 'Yes', 'status' => 'Active'];
        }

    }

    public function deleteAgent($id)
    {
        $user = new User();
        $agent = $user->destoryAgent($id);
        return redirect()->route('agents');
    }

    public function deleteVendor(Request $request)
    {
        $id = $request->id;
        $obj = new BgShop();
        $vendor = $obj->fetchSpecificVendor($id);
        $user = $vendor->user()->first();
        $vendor->delete();
        $qry = $user->delete();
        if ($qry) {
            return 'true';
        }
    }
}

