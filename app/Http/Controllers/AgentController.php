<?php
/**
 * Created by PhpStorm.
 * User: soft
 * Date: 02-May-19
 * Time: 5:37 PM
 */

namespace App\Http\Controllers;


use App\Models\Ad;
use App\Models\Agent;
use App\Models\BgShop;
use App\Models\Category;
use App\Models\Package;
use App\Models\Remark;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AgentController extends Controller
{

    public function save(Request $request)
    {
        $formData = $request->all();
        $validation = $this->validate($request,
            [
                'name' => 'required|min:3|max:30|unique:users',
                'email' => 'required|email|unique:users',
                'address' => 'required',
                'contact_number' => 'required|digits:11|numeric',
                'salary' => 'required|numeric',
                'qualification' => 'required|max:20',
                'date_of_joining' => 'required|date',
            ]);

        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
        $password = substr($random, 0, 5);

        $userTableAttr = $request->only('name', 'email', 'address', 'contact_number', 'latitude', 'longitude');

        $users = new User();
        $saveUser = $users->saveAgent($userTableAttr, $password);

        $array = [
            'user_id' => $saveUser['id'],
            'salary' => $formData['salary'],
            'qualification' => $formData['qualification'],
            'date_of_joining' => $formData['date_of_joining'],
        ];
        $agent = new Agent();
        $addAgent = $agent->saveAgent($array, $password);

        if ($addAgent && $saveUser) {
            Session::flash('success', 'Agent Is Added Successfully and Password is sent to Email');
            return redirect()->route('creatAgent');
        } else {
            return redirect()->route('createAgent')->withInput();
        }
    }

    public function editForm($id)
    {
        $agentData = User::find($id);
        return view('admin.edit-agent', compact('agentData'));
    }

    public function edit(Request $request, $id)
    {
        $formData = $request->all();

        $validation = $this->validate($request,
            [
                'name' => 'required',
                'email' => 'required|email',
                'address' => 'required',
                'contact_number' => 'required|digits:11|numeric',
                'salary' => 'required|numeric',
                'qualification' => 'required|max:20',
                'date_of_joining' => 'required|date',
            ]);

        $userTableAttr = $request->only('name', 'email', 'address', 'contact_number', 'latitude', 'longitude');
        $users = new User();
        $saveUser = $users->updateAgent($userTableAttr, $id);

        $array = [
            'salary' => $formData['salary'],
            'qualification' => $formData['qualification'],
            'date_of_joining' => $formData['date_of_joining'],
        ];
        $agent = new Agent();
        $addAgent = $agent->editAgent($array, $id);

        if ($addAgent && $saveUser) {
            Session::flash('success', 'Agent Is Updated Successfully');
            return redirect()->route('agents');
        } else {
            return redirect()->route('editAgentForm', compact('id'))->withInput();
        }
    }


    public function agentPanel()
    {
        $bgShop = new BgShop();
        $agent = Auth::user()->agent()->first()->id;
        $users = $bgShop->fetchVendor($agent);
        return view('agent.home', compact('users'));
    }

    public function vendorRequest()
    {
        $bgShop = new BgShop();
        $agent = Auth::user()->agent()->first()->id;
        $vendors = $bgShop->fetchVendor($agent);
        return view('agent.vendor-requests', compact('vendors'));
    }

    public function verifyLocation(Request $request)
    {
//        dd($request->all())
        $remark = new Remark();
        $formData = $request->all();
        $id = $request->input('vendor_id');
        $obj = new BgShop();
        $record = BgShop::find($id);
        $vendor = $obj->fetchSpecificVendor($record->user_id);
        $agent = $vendor->agent()->first();
        $admin = User::where('type', 'admin')->first();
        $saveRemark = $remark->saveRemark($vendor,$formData);
        if ($admin->id != $saveRemark->user_id) {
            Session::flash('location', 'Remark has been submitted');
            $vendor->is_verified = 'yes';
            $vendor->save();

            Notification::create([
                'target_id' => $vendor->user_id,
                'user_id' => $admin->id,
                'message' => "Agent " . Auth::user()->name . " is verified location of " . $vendor->shop_name . " activate their account",
                'type' => "verifyAccount",
            ]);
            return redirect()->back();
        }else{
            Session::flash('location', 'Remark has been submitted');
            $vendor->is_verified = 'no';
            $vendor->save();

            Notification::create([
                'target_id' => $vendor->id,
                'user_id' => $agent->user_id,
                'message' => "Admin response to your Remark",
                'type' => "doRemark",
            ]);
            return redirect()->back();
        }
    }

    public function agentRemarks($id){
        $bgShop = new BgShop();
        $vendor = BgShop::find($id);
        $remarks = Remark::where('bgShop_id',$vendor->id)->get();
        $currentLocation = Remark::where('bgShop_id',$vendor->id)->orderBy('created_at','desc')->first();
        return view('agent.agent-remarks', compact('vendor','remarks','currentLocation'));
    }

    public function addCategoryView()
    {
        $cate = new Category();
        $dropCats = $cate->categoryfetch();
        return view('agent.add-category', compact('dropCats'));
    }

    public function addCategory(Request $request)
    {
        $formData = $request->all();
        $this->validate($request,
            [
                'name' => 'required|min:3|max:30|unique:categories',
                'parent_id' => 'required|numeric',
            ]);
        $cate = new Category();
        $cates = $cate->addCategory($formData);
        if ($cates) {
            Session::flash('saveCat', 'Category Added successfully');
            return redirect()->route('addCategoryView');
        } else {
            return redirect()->back();
        }
    }



    public function agentNotification($notification = null)
    {
        $notify = Notification::find($notification);
        Notification::where('id', $notification)->first()->update(['status' => 1]);
        $type = $notify['type'];
        switch ($type) {
            case 'locationVerify':
                return redirect()->route('vendorRequest');
                break;
            case 'agentPanel':
                return redirect()->route('agentPanel');
                break;
            case 'doRemark':
                return redirect()->route('agentRemarks',[$notify['target_id']]);
                break;
            default:
                return redirect()->back();
                break;
        }
    }

}
