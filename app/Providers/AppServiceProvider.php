<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Notification;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
//        Passport::ignoreMigrations;
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer('layout.frontend-layout', function ($view) {
            $countItems = 0;
            $count=0;
            $cartQty=0;
            $notifications = '';
            if (Auth::check()) {
                $wishList = new Wishlist();
                try {
                    $cartQty = Cart::where('user_id', Auth::user()->id)->where('is_placed', 0)->first()->total_product;
                }catch (\Exception $e){
                    $cartQty = 0;
                }
                $countItems = $wishList->countWishs();
                $notifications = Notification::where('user_id', Auth::user()->id)->where('visibility',1)->orderBy('id','desc')->get();
                $count = Notification::where('user_id', Auth::user()->id)->where('visibility',1)->where('status', 0)->count();
            }
            $view->with([
                'countItems' => $countItems,
                'cartQty'=>$cartQty,
                'notifications' => $notifications,
                'count'=>$count,
            ]);
        });
        view()->composer('layout.backend-layout', function ($view) {
            $notifications = '';
            $count=0;
            if (Auth::check()) {
                $notifications = Notification::where('user_id', Auth::user()->id)->where('visibility',1)->orderBy('id','desc')->get();
                $count = Notification::where('user_id', Auth::user()->id)->where('visibility',1)->where('status', 0)->count();
            }
            $view->with([
                'notifications'=> $notifications,
                'count'=>$count,
            ]);
        });
        view()->composer('layout.agent-layout', function ($view) {
            $notifications = '';
            $count=0;
            if (Auth::check()) {
                $notifications = Notification::where('user_id', Auth::user()->id)->where('visibility',1)->orderBy('id','desc')->get();
                $count = Notification::where('user_id', Auth::user()->id)->where('visibility',1)->where('status', 0)->count();
            }
            $view->with([
                'notifications'=> $notifications,
                'count'=>$count,
            ]);
        });
        view()->composer('layout.vendor-layout', function ($view) {
            $notifications = '';
            $count=0;
            if (Auth::check()) {
                $notifications = Notification::where('user_id', Auth::user()->id)->where('visibility',1)->orderBy('id','desc')->get();
                $count = Notification::where('user_id', Auth::user()->id)->where('visibility',1)->where('status', 0)->count();
            }
            $view->with([
                'notifications'=> $notifications,
                'count'=>$count,
            ]);
        });
        view()->composer('layout.rider-layout', function ($view) {
            $notifications = '';
            $count=0;
            if (Auth::check()) {
                $notifications = Notification::where('user_id', Auth::user()->id)->where('visibility',1)->orderBy('id','desc')->get();
                $count = Notification::where('user_id', Auth::user()->id)->where('visibility',1)->where('status', 0)->count();
            }
            $view->with([
                'notifications'=> $notifications,
                'count'=>$count,
            ]);
        });
    }
}
