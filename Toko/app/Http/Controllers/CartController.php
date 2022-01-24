<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Cart;

class CartController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function view() {
        $user = Auth::user();
        if ($user->cart == null) {
            $cart = new Cart;
            $cart->user_id = $user->id;
            $cart->save();
            return redirect()->route('cart-view');
        }

        $cart = $user->cart->orders;
        $total = 0;
        foreach ($cart as $order) {
            $total += ($order->product->price * $order->quantity);
        }
        return view('auth.member.cart', compact('cart'))->with(['total' => $total]);
    }
    public function clear() {
        $user = Auth::user();
        if ($user->cart != null) {
            foreach($user->cart->orders as $order) {
                $order->delete();
            }
        }
        return redirect()->back();
    }
}
