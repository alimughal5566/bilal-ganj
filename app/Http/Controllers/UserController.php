<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\Product;
use App\Models\RiderLog;
use App\Models\User;
use App\Models\BgShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserController constructor.
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('user.login-register-form');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerAsUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:30|unique:users',
            'email' => 'required|email|unique:users',
            'address' => 'required',
            'password' => 'required|min:5',
            'contact_number' => 'required|digits:11|numeric',
        ]);
        if($validator) {
            $foamdata = $request->all();
            $user = new User();
            $savedUser = $user->saveUser($foamdata);
            $name = $savedUser['name'];
            $email = $savedUser['email'];
            $id = 'create';
            Mail::to($email)->send(new SendEmail($name, $email, $id));

            if ($savedUser) {
                Session::flash('registerAlert', 'Activation link send to your Email Account');

                return redirect()->route('login');
            }
        }else{
            Session::flash('registerAlert', 'Please try Again');
            return back();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forgetPassView()
    {
        return view('user-account.forget-password');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forgetPass(Request $request)
    {
        $validator = Validator::make($request->email, [
            'email' => 'required|email',
        ]);
        if($validator){
            $foamdata = $request->all();
            $user = new User();
            $array = $user->getUser($foamdata['email']);
            $name = $array['name'];
            $email = $array['email'];
            $id = 'reset';
            Mail::to($email)->send(new SendEmail($name, $email, $id));
            Session::flash('restAlert', "Go to your Email for Reset Password.");
            return redirect()->route('forgetPassword');
        }
    }

    /**
     * @param $email
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendEmailDone($email)
    {
        $user = new User();
        $verifiedUser = $user->getEmailUser($email);
        if ($verifiedUser) {
            Session::flash('emailVerify','Email is verified Please Login');
            return redirect()->route('login');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forgetPasswordView()
    {
        return view('user-account.forget-password');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forgetPassword(Request $request)
    {
        $email = $request->email;
        $id = 'forget';
        $user = new User();
        $user = $user->forgetPassword($email);
        if($user) {
            Mail::to($email)->send(new SendEmail($user->name, $email, $id));
            if ($user) {
                Session::flash('resetPass', 'Forget Password link send to Your Email');
                return redirect()->route('login');
            }
        }else{
            Session::flash('resetPassFail', 'Your Email does not found Please correct it');
            return back();
        }
    }

    /**
     * @param $email
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forgetPasswordDoneView($email)
    {
        $email = $email;
        return view('user-account.reset-password', compact('email'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function forgetPasswordDone(Request $request)
    {
        $this->validate($request,
            [
                'password'=>'required|min:5',
                'confirmPassword'=>'required|min:5'
            ]
            );
        $confirmPassword=$request->confirmPassword;
        $email = $request->email;
        $password = $request->password;
        if ($password==$confirmPassword) {
            $user = new User();
            $qry = $user->forgetPasswordDone($email, $password);
            if ($qry) {
                Session::flash('passwordChanged', 'Password changed Successfully');
                return redirect()->route('login');
            }
        }
        else
            {
                Session::flash('match', 'password does not match');
                return redirect()->route('forgetPasswordDoneView', compact('email'))->withInput();
            }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registerAsVendor()
    {
        return view('user.vendor-registration-form');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authUser(Request $request)
    {

        $formdata = $request->all();
        $this->validate($request, [
            'Email' => 'required|email|exists:users,email',
            'Password' => 'required|min:5',
        ]);
        $user = User::where('email',$formdata['Email'])->first();

        if (Auth::attempt(['email' => $formdata['Email'], 'password' => $formdata['Password']])) {
            switch (Auth::user()->type) {
                case 'user':
                    if (Auth::user()->is_active === 'Yes') {
                        return redirect()->route('index');
                    }
                    else {
                        Session::flash('authFailed', 'Please Verify your Email First');
                        return redirect()->route('login');
                    }
                case 'admin':
                    return redirect()->route('displayAdmin');
                    break;
                case 'agent':
                    return redirect()->route('agentPanel');
                    break;
                case 'bgshop':
                    return redirect()->route('vendorPanel');
                    break;
                case 'rider':
                    return redirect()->route('riderPanel');
                    break;
            }
        }
        elseif ($user===null){
            Session::flash('blocked', 'Your Account has been Blocked');
            return redirect()->route('login');
        }
        else {
            return redirect()->back()->withInput()->with(['message' => 'Password is Invalid']);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function saveVendor(Request $request)
    {
        $formdata = $request->all();
        $this->validate($request, [
            'name' => 'required|min:3|max:30|unique:users',
            'email' => 'required|email|unique:users',
            'address' => 'required',
            'shop_name' => 'required',
            'password' => 'required|min:5',
            'contact_number' => 'required|digits:11|numeric'
        ]);
        $userTableAttr = $request->only('name', 'email', 'password', 'address', 'contact_number','latitude','longitude');
        $user = new User();
        $addedUser = $user->saveVendor($userTableAttr);
        $bgShop = new BgShop();
        $array = [
            'user_id' => $addedUser['id'],
            'shop_name' => $formdata['shop_name'],
            'opening_time' => $formdata['opening_time'],
            'closing_time' => $formdata['closing_time']
        ];
        $addedBgShop = $bgShop->saveBgShop($array);
        if ($addedBgShop && $addedUser) {
            Session::flash('success', 'Your Request has submitted for Approval');
            return redirect()->route('registerAsVendor');
        }
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function saveContactUsInfo(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:30|alpha',
            'email' => 'required|email|unique:users',
            'subject' => 'required',
            'message' => 'required'
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()-> route('index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead()
    {
        Notification::where('user_id',Auth::user()->id)->update(['visibility'=>0,'status'=>1]);
        return redirect()->back();
    }

    /**
     * @param null $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userNotification($notification=null){
        $notify = Notification::find($notification);
        Notification::where('id',$notification)->first()->update(['status'=>1]);
        $type = $notify['type'];
        switch ($type) {
            case 'startOrder':
                return redirect()->route('userAccount');
                break;
            default:
                return redirect()->back();
                break;
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchProducts(Request $request){
        $query = $request->input('name');
        $obj = new Product();
        $products = $obj->fetchRecommendedProducts($query);
        $allProducts = $products;
        $sortHide = true;
        $shop = new BgShop();
        $manufactures = $shop->fetchVendors();
        return view('home.shop',compact('products','allProducts','sortHide','manufactures'));
    }

    /**
     * @param Request $request
     */
    public function searchProductsList(Request $request){
        $name = $request->name;
        $obj = new Product();
        $data = $obj->fetchRecommendedProducts($name);
        $output = "<div class='list-group product_list_group'>";
        foreach($data as $row){
            $output .= "<a class='list-group-item list-group-item-action'>$row->name</a>";
        }
        $output .= "</div>";

        echo $output;
    }
}


