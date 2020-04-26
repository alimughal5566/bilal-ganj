<?php

namespace App\Http\Controllers;

use App\Models\BgShop;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rider;
use App\Models\RiderLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    private $notification;
    private $orderObj;
    private $riderLogObj;

    public function __construct(Notification $notification, Order $order, RiderLog $log)
    {
        $this->notification = $notification;
        $this->orderObj = $order;
        $this->riderLogObj = $log;
    }

    public function doOrder($total = null, $orderAmount = null)
    {
        try {
            $cart = Cart::where('user_id', Auth::user()->id)->where('is_placed', 0)->first();
            $products = $cart->products()->get();
            $count = $cart->countCartItems();
            return view('home.checkOutView', compact('products', 'count', 'total', 'orderAmount'));
        } catch (\Exception $e) {
            session()->flash('alert', 'Please add Product in your cart then Place Order');
            return redirect()->route('cart');
        }

    }

    public function orderDetails($id, $flag = null)
    {
        $order = Order::find($id);
        $cart = $order->cart()->first();
        $products = $cart->products()->get();
        if (!$flag) {
            return view('user-account.order-details', compact('products'));
        } else {
            return view('admin.admin-order-details', compact('products'));
        }
    }

    public function orderList()
    {
        $orders = Order::all();
        $time = Order::latest('updated_at')->first();
        return view('admin.order-list', compact('orders', 'time'));
    }

    public function placeOrder(Request $request)
    {
//        dd($request);
        $cart = Cart::where('user_id', Auth::user()->id)->where('is_placed', 0)->first();
        $rider = null;

        $time = $request->estimated_time;
//            dd($time);
        $this->orderObj->calculateDateTime($cart, $request, $time);

        $order = Order::where('user_id', Auth::user()->id)->where('cart_id', $cart->id)->first();
        $count = $cart->products()->get()->count();
        $getPivot[] = $size[] = null;
        for ($i = 0; $i < $count; $i++) {
            $getPivot[$i] = $cart->products()->wherePivot('cart_id', $cart->id)->get()[$i]->pivot;
            $product[$i] = Product::find($getPivot[$i]->product_id);
            $ucp = $product[$i]->ucp * $getPivot[$i]->quantity;
            $vendor[$i] = BgShop::find($product[$i]->bgshop_id);
            $tenPer = ($ucp * 10 / 100) / 10;
            $vendor[$i]->credit -= $tenPer;
            $vendor[$i]->save();
            $product[$i]->quantity -= $getPivot[$i]->quantity;
            $product[$i]->save();
            $size[$i] = $cart->products()->get()[$i]->size;

        }
        $small = $medium = $large = 0;
        for ($i = 0; $i < $count; $i++) {
            $quantity[$i] = $getPivot[$i]->quantity;
            switch ($quantity[$i] && $size[$i]) {
                case $size[$i] == 'Small' && $quantity[$i] >= 8:
                    $medium++;
                    break;
                case $size[$i] == 'Medium' && $quantity[$i] >= 3:
                    $large++;
                    break;
                case $size[$i] == 'Large' && $quantity[$i] >= 5:
                    $large++;
                    break;
                case $size[$i] == 'Medium' && $quantity[$i] < 5:
                    $medium++;
                    break;
                case $size[$i] == 'Large' && $quantity[$i] < 5:
                    $large++;
                    break;
                default:
                    $small++;
                    break;
            }
        }
        $saveRider = null;
        $ride = new RiderLog();
        if ($large != 0) {

            $riderExist = Rider::where('vehicle_type', 'pickup')->where('status', 'free')->exists();
            if ($riderExist) {
                $rider = Rider::where('vehicle_type', 'pickup')->where('status', 'free')->first();
            } else {
                $riders = Rider::where('vehicle_type', 'pickup')->get();
                $result = $this->riderLogObj->calculateDistance($riders, $request);
                $rider = Rider::find($result['rider_id']);
//                        $this->orderObj->calculateDateTime($cart, $request, $result['distance'], true);
            }

            $saveRider = $ride->createLog($request, $order, $rider);
        } elseif ($medium != 0) {
            $riderExist = Rider::where('vehicle_type', 'loadingRickshaw')->where('status', 'free')->exists();
            if ($riderExist) {
                $rider = Rider::where('vehicle_type', 'loadingRickshaw')->where('status', 'free')->first();
            } else {
                $riders = Rider::where('vehicle_type', 'loadingRickshaw')->get();
                $result = $this->riderLogObj->calculateDistance($riders, $request);
                $rider = Rider::find($result['rider_id']);
//                        $this->orderObj->calculateDateTime($cart, $request, $result['distance'], true);
            }

            $saveRider = $ride->createLog($request, $order, $rider);
        } else {

            $riderExist = Rider::where('vehicle_type', 'bike')->where('status', 'free')->exists();
            if ($riderExist) {
                $rider = Rider::where('vehicle_type', 'bike')->where('status', 'free')->first();
            } else {
                $riders = Rider::where('vehicle_type', 'bike')->get();
                $result = $this->riderLogObj->calculateDistance($riders, $request);
                $rider = Rider::find($result['rider_id']);
//                        $this->orderObj->calculateDateTime($cart, $request, $result['distance'], true);
            }
            $saveRider = $ride->createLog($request, $order, $rider);
        }
        if ($saveRider) {
            $cart->is_placed = 1;
            $cart->save();
            $this->notification->notify($rider->user()->first()->id, 'You have a new Ride', 'ride');
            return redirect()->route('cart')->with(['checkout' => 'Your Order has been placed check']);
        }
    }

    public function adminOrderDetails($id)
    {
        return $this->orderDetails($id, true);
    }
}
