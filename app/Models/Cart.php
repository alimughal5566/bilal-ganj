<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    protected $guarded = [
        'id', '_token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'carts_products', 'cart_id', 'product_id')
            ->withPivot(['id', 'cart_id', 'product_id', 'quantity']);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function saveCart($formData)
    {
        $user_id = $formData['user_id'];
        $product_id = $formData['product_id'];
        $cart = Cart::where('user_id', $user_id)->where('is_placed', 0)->first();
        if (!$cart || $cart === null) {
            $cart = Cart::create([
                'user_id' => $formData['user_id'],
            ]);
            $cart->products()->attach($formData['product_id']);
            $getCart = $cart->products()->wherePivot('cart_id', $cart->id)->wherePivot('product_id', $product_id)->first()->pivot;
            $cart->products()->updateExistingPivot($product_id, ['quantity' => $getCart->quantity + 1]);

        } else {
            try {
                $getCart = $cart->products()->wherePivot('cart_id', $cart->id)->wherePivot('product_id', $product_id)->first()->pivot;
            } catch (\Exception $e) {
                $cart->products()->attach($formData['product_id']);
                $getCart = $cart->products()->wherePivot('cart_id', $cart->id)->wherePivot('product_id', $product_id)->first()->pivot;
            }

            $cart->products()->updateExistingPivot($product_id, ['quantity' => $getCart->quantity + 1]);
            $count = DB::table('carts_products')->where('cart_id', $cart->id)->get()->sum('quantity');
            $cart->total_product = $count;
            $cart->save();
        }
        return $cart;
    }

    public function deleteCart($id)
    {
        $cart = Cart::where('user_id', Auth::user()->id)->where('is_placed', 0)->first();
        $items = $cart->products()->wherePivot('product_id', $id)->first()->pivot->delete();
        $count = DB::table('carts_products')->where('cart_id', $cart->id)->get()->sum('quantity');
        $cart->total_product = $count;
        $cart->save();
        return $items;
    }

    public function updateCart($id, $qantity, $callback=null)
    {
        $cart = Cart::where('user_id', Auth::user()->id)->where('is_placed', 0)->first();

        $getCart = $cart->products()->wherePivot('product_id', $id)->first()->pivot;
        $cart->products()->updateExistingPivot($id, ['quantity' => isset($callback)? $getCart->quantity - 1:$getCart->quantity + 1]);
        $count = DB::table('carts_products')->where('cart_id', $cart->id)->get()->sum('quantity');
        $cart->total_product = $count;
        $cart->save();
        return $cart;
    }

    public function countCartItems($id = null)
    {
//        dd(Auth::user()->id);
        if ($id == null){
            $qry = Cart::where('user_id', Auth::user()->id)->where('is_placed', 0)->first()->total_product;
        }else{
            $qry = Cart::where('user_id', $id)->where('is_placed', 0)->first()->total_product;
        }
        return $qry;
    }

    public function countCartItem($id = null)
    {
        if ($id == null){
            $qry = Cart::where('user_id', Auth::guard('api')->user()->id)->where('is_placed', 0)->first()->total_product;
        }else{
            $qry = Cart::where('user_id', $id)->where('is_placed', 0)->first()->total_product;
        }
        return $qry;
    }

    public function deleteCartItem($id,$quantity){
        $this->updateCart($id,$quantity,1);
    }
}
