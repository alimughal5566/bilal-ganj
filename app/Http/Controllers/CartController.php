<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private $cart;

    /**
     * CartController constructor.
     * @param $cart
     */
    public function __construct(Cart $cart )
    {
        $this->cart = $cart;
    }


    public function addToCart(Request $request)
    {
        $array = [
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
        ];
        if (Auth::check()) {
            if (!$qty = $request->get_quantity) {
                $cart = $this->cart->saveCart($array);
            } else {
                for ($i = 0; $i < $qty; $i++) {
                    $cart = $this->cart->saveCart($array);
                }
            }
            $countItems = $this->cart->countCartItems();
        }
        return $countItems;
    }

    public function getCart($id = null)
    {
        try {
            $cart = Cart::where('user_id', Auth::user()->id)->where('is_placed', 0)->first();
            $products = null;
            if ($cart) {
                $products = $cart->products()->get();
                $count = $this->cart->countCartItems();
            }
            return view('home.cart', compact('products','count'));
        }catch (\Exception $e){
            $products = null;
            $count=0;
            return view('home.cart', compact('products','count','id'));
        }

    }

    public function deleteCart(Request $request)
    {
        $result = $this->cart->deleteCart($request->id);
        $countItems = $this->cart->countCartItems();
        if($countItems==0){
            Cart::where('user_id', Auth::user()->id)->where('is_placed', 0)->delete();
        }
        return $countItems;
    }

    public function updateCart(Request $request, $callback = null)
    {
        $id = $request->product_id;
        $quantity = $request->get_quantity;
        $result = '';
        if (!isset($callback)) {
            for ($i = 0; $i < $quantity; $i++) {
                $result = $this->cart->updateCart($id, $quantity);
            }
        }else{
            for ($i = $quantity ; $i < 0 ; $i++ ){
                $result = $this->cart->deleteCartItem($id, $quantity);
            }
        }
        $cart = Cart::where('user_id', Auth::user()->id)->where('is_placed', 0)->first();
        $products = null;
        if ($cart) {
            $products = $cart->products()->get();
            $count = $this->cart->countCartItems();
        }
        return view('home.include.cart-data', compact('products','count'));
    }

    public function deleteCartItem(Request $request)
    {
        return $this->updateCart($request, 1);
    }
}
