<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Contracts\Factory as Socialite;




class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Socialite $socialite)
    {
        $this->socialite = $socialite;
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider = null)
    {
//        dd($provider);
         return $this->socialite->with($provider)->redirect();

    }


    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider = null)
    {

        $user = $this->socialite->with($provider)->stateless()->user();

        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
        $password = substr($random, 0, 5);
        $getUser = User::where('email', $user->email)->first();
        if (!$getUser) {
            $authUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'address' => null,
                'contact_number' => null,
                'is_active' => 'Yes',
                'password' => Hash::make($password),
            ]);
            Notification::create([
                'user_id' => $authUser->id,
                'message' => "Hi $authUser->name welcome To Bilal Ganj",
            ]);
            Auth::login($authUser);
            return redirect()->route('index');

        } else {
            Auth::login($getUser);
            return redirect()->route('index');
        }
    }
}
