<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use App\Models\BgShop;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rider;
use App\Models\RiderLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public $successStatus = 200;
    public $errorsStatus = 401;

    public function __construct(Cart $cart, Order $order, RiderLog $riderLog , Notification $notification)
    {
        $this->cart = $cart;
        $this->orderObj = $order;
        $this->riderLogObj = $riderLog;
        $this->notification = $notification;
    }

    public function authUser(){
        if(Auth::attempt(['email'=>request('email'), 'password'=>request('password')])){
            $user = Auth::user();
            $user = User::where('email',$user->email)->first();
            if ($user) {
                $success['token'] =  $user->createToken('bilalganj')-> accessToken;
                switch (Auth::user()->type) {
                    case 'user':
                        if (Auth::user()->is_active === 'Yes') {
                            return response()->json(['success' => $success, 'user'=> $user], $this-> successStatus);
                        }

                    case 'rider':
                        return response()->json(['success' => $success, 'user'=> $user], $this-> successStatus);
                        break;
                }
            }


        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }



    public function registerAsUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:30|unique:users',
            'email' => 'required|email|unique:users',
            'address' => 'required',
            'password' => 'required|min:5',
            'contact_number' => 'required|digits:11|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data' => $validator->errors()],
                $this->errorsStatus);
        }
        else {
            $msg = 'Registration Successful! Please Verify Email Address...';
            $user = $request->all();
            $user['password'] = Hash::make($user['password']);

            $user = User::create($user);
            $name = $user->name;
            $email = $user->email;
            $id = 'create';
            Mail::to($user->email)->send(new SendEmail($name, $email, $id));
            $success['token'] = $user->createToken('bilalganj')->accessToken;
            $success['name'] = $user->name;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }

    public function registerAsVendor(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:30|unique:users',
            'email' => 'required|email|unique:users',
            'address' => 'required',
            'shop_name' => 'required',
            'password' => 'required|min:5',
            'contact_number' => 'required|digits:11|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data' => $validator->errors()],
                $this->errorsStatus);
        }
        else {
            $msg = 'Registration Successful! Please Verify Through Agent...';
            $user = new User();
            $userData = $request->only('name', 'email', 'password', 'address', 'contact_number','latitude','longitude');
            $user = $user->saveVendor($userData);
            $vendor = $request->only('user_id', 'shop_name', 'opening_time', 'closing_time');
            $vendor['user_id'] = $user['id'];
            $vendor = BgShop::create($vendor);
            if($user && $vendor) {
                $success['token'] = $user->createToken('bilalganj')->accessToken;
                return response()->json(['success' => $msg], $this->successStatus);
            }
        }
    }

    public function profileUser()
    {
        $user = Auth::user();
//        $user = User::all();
        $success['token'] = $user->createToken('bilalganj')->accessToken;
        return response()->json(['success' => $user], $this-> successStatus);
    }

    public function updateProfileUser(Request $request){
        $validator = Validator::make($request->all(), [
            'address' => 'required',
            'contact_number' => 'required|digits:11|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data' => $validator->errors()],
                $this->errorsStatus);
        }else{
            $formdata = $request->all();
            $user = new User();
            $user = $user->updateUser($formdata);
            $success['token'] = $user->createToken('bilalganj')->accessToken;
            if($user){
                return response()->json(['success' => $user], $this-> successStatus);
            }
        }
    }

    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data' => $validator->errors()],
                $this->errorsStatus);
        }
        else{
            $email = $request->email;
            $user = User::where('email', $email)->first();
            if($user) {
                $msg = 'Successful! Please Check Your Email To Reset Your Password...';
                $name = $user->name;
                $id = 'forget';
                Mail::to($email)->send(new SendEmail($name, $email, $id));
                $success['token'] = $user->createToken('bilalganj')->accessToken;
                return response()->json(['success' => $success, 'message' => $msg], $this->successStatus);
            }
            else{
                return response()->json(['error'=>'Unauthorised'], 401);
            }
        }

    }

    public function forgetPasswordDone(Request $request){
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'password'=>'required|min:5',
            'confirmPassword'=>'required|min:5'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data' => $validator->errors()],
                $this->errorsStatus);
        }else{

            $msg = 'Successful! Your Password Changed...';
            $confirmPassword=$request->confirmPassword;
            $email = $request->email;
            $password = $request->password;
            if ($password==$confirmPassword) {
                $user = new User();
                $qry = $user->forgetPasswordDone($email, $password);
                if ($qry) {
                    $success['token'] = $user->createToken('bilalganj')->accessToken;
                    return response()->json(['Success' => $msg], $this-> successStatus);
                }
            }
            else
            {
                return response()->json(['error'=>'Unauthorised'], 401);
            }
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:5',
            'password' => 'required|min:5',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data' => $validator->errors()],
                $this->errorsStatus);
        }
        else{
            $msg = 'Password has been successfully changed';
            $formdata =$request->all();
            $user = new User();
            $userdata = User::find($formdata['user_id']);
            $user= $user->updatePassword($formdata);

            if($user) {
                $success['token'] = $userdata->createToken('bilalganj')->accessToken;
                return response()->json(['success' => $success, 'message' => $msg], $this->successStatus);
            }
            else{
                return response()->json(['error'=>'Unauthorised'], 401);
            }
        }
    }

    public function searchProducts(Request $request)
    {
        $query = $request->input('name');
        $obj = new Product();
        $products = $obj->fetchRecommendedProducts($query);
        return response()->json(['success' => $products], $this->successStatus);
    }

    public function details()
    {
        $user = auth()->user();
        $success['token'] = $user->createToken('bilalganj')->accessToken;
        return response()->json(['success' => $user], $this-> successStatus);
    }



    public function getCart($id = null)
    {
        $user = Auth::user();
        try {
            $cart = Cart::where('user_id', Auth::user()->id)->where('is_placed', 0)->first();
            $products = null;
            $count = null;
            if ($cart) {
                $products = $cart->products()->get();
                $count = $this->cart->countCartItems($id);
            }
            $success['token'] = $user->createToken('bilalganj')->accessToken;
            return response()->json(['success' => $user ,'products' => $products , 'count' => $count], $this-> successStatus);
        }
        catch (\Exception $e)
        {
            $products = null;
            $count=0;
            return response()->json(['products' => $products , 'count' => $count , 'id' => Auth::user()], $this-> errorsStatus);
        }

    }

    public function addToCart(Request $request){
        $array = [
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
        ];
//        dd(Auth::guard('api')->check());
//        $user = User::find($request->user_id)->first();
        if (Auth::guard('api')->check()) {
            if (!$qty = $request->get_quantity) {
                $cart = $this->cart->saveCart($array);
            } else {
                for ($i = 0; $i < $qty; $i++) {
                    $cart = $this->cart->saveCart($array);
                }
            }
            $countItems = $this->cart->countCartItem();
        }
        return response()->json(['status' => 'success', 'countItems' => $countItems], $this->successStatus);
    }
    public function placeOrder(Request $request)
    {

        $user = Auth::user();
        $cart = Cart::where('user_id', Auth::user()->id)->where('is_placed', 0)->first();
        $rider = null;
        $time = $request->estimated_time;
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
        if ($saveRider)
        {
            $cart->is_placed = 1;
            $cart->save();
            $this->notification->notify($rider->user()->first()->id, 'You have a new Ride', 'ride');
            $success['token'] = $user->createToken('bilalganj')->accessToken;
            return response()->json(['success' => $user], $this-> successStatus);
        }

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

}
