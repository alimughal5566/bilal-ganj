<?php
/**
 * Created by PhpStorm.
 * User: soft
 * Date: 7/19/2019
 * Time: 9:58 AM
 */

namespace App\Http\Controllers;


use App\Models\BgShop;
use App\Models\Credit;
use App\Models\Payment;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;

class CreditController
{
    public function creditsView($id)
    {
        $obj2 = new BgShop();
        $obj = new Credit();
        $vendor = $obj2->fetchSpecificVendor($id);
        $credit = $obj->fetch($vendor->id);
        return view('vendor.credit-history' , compact('credit', 'vendor'));
    }
    public function buyCreditsView($id)
    {
        $obj2 = new BgShop();
        $vendor = $obj2->fetchSpecificVendor($id);
        return view('vendor.buy-credits' , compact( 'vendor'));
    }
    public function getCredit(Request $request , $id)
    {
      $comment = $request->validate([
            'cardNumber' => 'required|numeric|digits:16',
            'cardName' => 'required',
            'expMonth' => 'required|digits:2|numeric',
            'expYear' => 'required|digits:4|numeric',
            'cvc' => 'required|digits:3|numeric',
            'amount'=>'required|numeric',
        ]);
        $obj2 = new BgShop();
        $vendor = $obj2->fetchSpecificVendor($id);
        try {

            $stripe = Stripe::make('sk_test_SC0vlNombHle8UkteUhGkEOh004jQUyGFo');

            $charge = $stripe->charges()->create([

                "card" => $request->stripeToken,
                "currency" => 'PKR',
                "amount" => $request->amount,
                "description" => 'add in vallet',

            ]);

            $total_credit = $vendor['credit'] +  $request['total_credits'];

            $payment = $request->only('amount' , 'user_id' , 'vendor_id' , 'total_credits');
            $paied = new Payment();
            $savePayment = $paied->savePayment($payment);
            $obj = new Credit();
            $savCredit = $obj->saveCredit($payment , $total_credit);
            $updateRecharge = $obj->updateCredit($total_credit , $request->user_id);
            if ($savePayment && $updateRecharge && $savCredit)
            {
                session()->flash('success', 'Your credit is successfully updated!. Check your transaction history');
                return redirect()->back()->with('vendor');
            }
        }
    catch (\Exception $e) {
        session()->flash('success', 'Your Card Number OR Dates are Invalid Please Correct them!');
        return back()->withInput();
    }
        return view('vendor.buy-credits' , compact( 'vendor'));
    }
}