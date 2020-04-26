<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Remark;
use App\Models\Rider;
use App\Models\RiderLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\Geocoder\Facades\Geocoder;

class RiderController extends Controller
{
    private $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function saveRider(Request $request)
    {
        $formData = $request->all();
        $this->validate($request,
            [
                'name' => 'required|min:3|max:30|unique:users',
                'email' => 'required|email|unique:users',
                'address' => 'required',
                'vehicle_number' => 'required',
                'contact_number' => 'required|digits:11|numeric',
                'salary' => 'required|numeric',
                'date_of_joining' => 'required|date',
            ]);

        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
        $password = substr($random, 0, 5);

        $userTableAttr = $request->only('name', 'email', 'address', 'contact_number', 'latitude', 'longitude');

        $users = new User();
        $saveUser = $users->saveRider($userTableAttr, $password);

        $array = [
            'user_id' => $saveUser['id'],
            'salary' => $formData['salary'],
            'vehicle_type' => $formData['vehicle_type'],
            'vehicle_number' => $formData['vehicle_number'],
            'date_of_joining' => $formData['date_of_joining'],
        ];
        $rider = new Rider();
        $saveRider = $rider->saveRider($array, $password);

        if ($saveUser && $saveRider) {
            Session::flash('success', 'Rider Is Added Successfully and Password is sent to Email');
            return redirect()->route('addRiderView');
        } else {
            return redirect()->route('addRiderView')->withInput();
        }
    }

    public function deleteRider($id)
    {
        $rider = new Rider();
        $qry = $rider->deleteRider($id);
        Session::flash('success', 'Record Deleted Successfully');
        return redirect()->route('viewRiders');
    }

    public function editRiderForm($id)
    {
        $user = User::find($id);
        return view('admin.edit-rider', compact('user'));
    }

    public function editRider(Request $request, $id)
    {

        $formData = $request->all();

        $this->validate($request,
            [
                'address' => 'required',
                'vehicle_number' => 'required',
                'contact_number' => 'required|digits:11|numeric',
                'salary' => 'required|numeric',
                'date_of_joining' => 'required|date',
            ]);

        $userTableAttr = $request->only('name', 'email', 'address', 'contact_number', 'latitude', 'longitude');
        $rider = new Rider();
        $saveUser = $rider->updateRider($userTableAttr, $id);

        $array = [
            'salary' => $formData['salary'],
            'vehicle_type' => $formData['vehicle_type'],
            'vehicle_number' => $formData['vehicle_number'],
            'date_of_joining' => $formData['date_of_joining'],
        ];

        $edited = $rider->editRider($array, $id);

        if ($edited && $saveUser) {
            Session::flash('success', 'Record Updated Successfully');
            return redirect()->route('viewRiders');
        } else {
            return redirect()->route('editRiderForm', compact('id'))->withInput();
        }
    }

    public function riderPanel()
    {
        $user = User::find(Auth::user()->id);
        return view('rider.home', compact('user'));
    }

    public function riderNotification($notification = null)
    {
        $notify = Notification::find($notification);
        Notification::where('id', $notification)->first()->update(['status' => 1]);
        $type = $notify['type'];
        switch ($type) {
            case 'dummy':
                break;
            case 'ride':
                return redirect()->route('scheduleRides');
                break;
            default:
                return redirect()->back();
                break;
        }
    }

    public function riderEditProfile($id)
    {
        $user = User::find($id);
        return view('rider.edit-profile', compact('user'));
    }

    public function riderEditedProfile(Request $request)
    {
        $formData = $request->except('user_id');
        $userId = $request->user_id;
        $this->validate($request, [
            'address' => 'required',
            'contact_number' => 'required|digits:11|numeric',
        ]);

        $qry = User::find($userId)->update([
            'address' => $formData['address'],
            'contact_number' => $formData['contact_number'],
        ]);
        if ($qry) {
            Session::flash('success', 'Profile information Updated Successfully');
            return redirect()->route('riderPanel');
        } else {
            return redirect()->back();
        }
    }

    public function riderChangePassword()
    {
        return view('rider.change-password');
    }

    public function riderChangedPassword(Request $request)
    {
        $formData = $request->all();
        $this->validate($request, [
            'old_password' => 'required|min:5',
            'password' => 'required|min:5'
        ]);

        $user = new User();
        $updatedUser = $user->updatePassword($formData);

        if ($updatedUser) {
            Session::flash('success', 'Password changed successfully');
            return redirect()->route('riderPanel');
        } else {
            return redirect()->back()->with(['error' => "Password doesn't matched"]);
        }

    }

    public function scheduleRides($flag = null)
    {
        $rider = Auth::user()->rider()->first();
        try {
            if (!isset($flag)) {
                $rides = RiderLog::where('rider_id', $rider->id)->where('status', '!=', 2)->orderBy('created_at', 'desc')->get();
            } else {
                $rides = RiderLog::where('rider_id', $rider->id)->where('status', 2)->orderBy('created_at', 'desc')->get();
            }
            $lat = $rides[0]->origin_latitude;
            $lng = $rides[0]->origin_longitude;
            $client = new \GuzzleHttp\Client();
            $geocoder = new \Spatie\Geocoder\Geocoder($client);
            $geocoder->setApiKey('AIzaSyDqSTkzPn8PpJBY3Pclu-TTjmGDLzqKMD4');
            $x = $geocoder->getAddressForCoordinates($lat, $lng);
        } catch (\Exception $e) {
            $rides = null;
        }
        if (!isset($flag)) {
            return view('rider.schedule-rides', compact('rides'));
        } else {
            return view('rider.ride-history', compact('rides'));
        }
    }

    public function trackRiderView($rideId, $orderId, $flag = null)
    {
        $ride = RiderLog::where('rider_id', $rideId)->where('order_id', $orderId)->first();
        $orderEstimatedTime = Order::find($orderId)->first()->estimated_time;
        $time = explode(' ', $orderEstimatedTime)[1];
        $getSeperateTime = explode(':', $time);
        $requiredTime = $getSeperateTime[0] . ':' . $getSeperateTime[1];
        if (!$flag) {
            RiderLog::where('rider_id', $rideId)->where('order_id', $orderId)->update(['status' => 1]);
            $rider = Rider::find($ride->rider_id);
            $rider->status = 'busy';
            $rider->save();
            $order = $ride->order()->first();
            $order->update(['status' => 'on the way']);
            $order->save();
            $id = $order->user()->first()->id;
            $this->notification->notify($id, 'Your order delivery are in progress', 'startOrder');
        }
        return view('rider.track-rider', compact('ride', 'requiredTime'));
    }

    public function saveStartTime(Request $request)
    {
        $updateRider = DB::table('rider_logs')->where('rider_id', $request->rID)->where('order_id', $request->oID)->update([
            'start_time' => $request->time,
            'distance'=>$request->calDistance,
            'end_time'=>$request->arrivalTime,
        ]);
        if ($updateRider) {
            return 'success';
        }
    }

    public function trackRider(Request $request)
    {
        return view('rider.track-rider');
        dd($request->all());
    }

    public function updateRiderLocation(Request $request)
    {
        RiderLog::where('order_id', $request->orderId)->update([
            'rider_latitude' => $request->reqLati,
            'rider_longitude' => $request->reqLng,
        ]);

        return 'success';
    }

    public function rideCompleted($id)
    {
        RiderLog::where('order_id', $id)->update([
            'status' => 2
        ]);
        $ride = RiderLog::where('order_id', $id)->first();
        $rider = Rider::where('id', $ride->rider_id)->first();
        $rider->status = 'free';
        $rider->save();
        $order = $ride->order()->first();
        $order->update(['status' => 'delivered']);
        $order->save();
        session()->flash('success', 'Your ride was completed');
        $id = $order->user()->first()->id;
        $this->notification->notify($id, 'Thanks for Order stay Tuned');
        return redirect()->route('scheduleRides');
    }

    public function rideHistory()
    {
        $flag = true;
        return $this->scheduleRides($flag);
    }

    public function viewOnMap($orderId)
    {
        $ride = RiderLog::where('order_id', $orderId)->first();
        return view('rider.show-ride', compact('ride'));
    }

    public function getLocation(Request $request)
    {
        $ride = RiderLog::where('order_id', $request->orderId)->first();

        return
            [
                'riderLat' => $ride->rider_latitude,
                'riderLng' => $ride->rider_longitude,
            ];
    }
}
