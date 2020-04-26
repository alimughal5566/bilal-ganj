<?php

namespace App\Http\Controllers;

use App\Models\BgShop;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rider;
use App\Models\RiderLog;
use Carbon\Carbon;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StripePaymentController extends Controller
{
    private $notification;
    private $orderObj;
    private $riderLogObj;

    /**
     * StripePaymentController constructor.
     */
    public function __construct(Notification $notification, Order $order, RiderLog $log)
    {
        $this->notification = $notification;
        $this->orderObj = $order;
        $this->riderLogObj = $log;
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe($total = null)
    {
        return view('home.stripe', compact('total'));
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $cart = Cart::where('user_id', Auth::user()->id)->where('is_placed', 0)->first();
        $rider = null;
        $comment = $request->validate([
            'cardNumber' => 'required|numeric|digits:16',
            'cardName' => 'required',
            'expMonth' => 'required|digits:2|numeric',
            'expYear' => 'required|digits:4|numeric',
            'cvc' => 'required|digits:3|numeric',
        ]);
        try {
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
                $stripe = Stripe::make('sk_test_SC0vlNombHle8UkteUhGkEOh004jQUyGFo');
                $charge = $stripe->charges()->create([
                    "card" => $request->stripeToken,
                    "currency" => 'PKR',
                    "amount" => $request->total,
                    "description" => 'add in vallet',

                ]);
                $cart->is_placed = 1;
                $cart->save();
                $this->notification->notify($rider->user()->first()->id, 'You have a new Ride', 'ride');
                return redirect()->route('cart')->with(['checkout' => 'Your payment was received and order is placed check']);
            } else {
                session()->flash('success', 'Your Card Number OR Dates are Invalid Please Correct them!');
                return back()->withInput();
            }

        } catch (\Exception $e) {
            session()->flash('success', 'Your Card Number OR Dates are Invalid Please Correct them!');
            return back()->withInput();
        }
    }
}


