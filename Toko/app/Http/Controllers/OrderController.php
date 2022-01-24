<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create(Request $request, $id) {
        $request->validate([
           'quantity' => 'required|min:1',
        ]);
        $user = Auth::user();
        $cart = $user->cart;
        $condition = true;
        if ($cart->orders != null) {
            foreach($cart->orders as $existOrder) {
                if ($existOrder->product_id == $id) {
                    $condition = false;
                    if ($existOrder->quantity + $request->quantity <= $existOrder->product->quantity) {
                        $existOrder->quantity += $request->quantity;
                        $existOrder->update();
                    } else {
                        $msg = 'FAILED@'.'There are '.$existOrder->product->quantity.' left in stock and you already have '.$existOrder->quantity.' in your cart.'; 
                        return $msg;
                    }
                    break;
                }
            }
        }
        $product = Product::find($id);
        if ($condition) {
            $order = new Order();
            $order->cart_id = $cart->id;
            $order->product_id = $id;
            $order->quantity = $request->quantity;
            $order->save();
        }
        $msg = 'SUCCESS@'.$request->quantity.' '.$product->name.' added to cart successfully.';
        return $msg;
    }

    public function update(Request $request, $id) {
        $request->validate([
           'quantity' => 'required|min:1',
        ]);
        $order = Order::find($id);
        if ($order->quantity + $request->quantity <= $order->product->quantity) {
            $order->quantity += $request->quantity;
            $order->save();
            $msg = 'FAILED@'.'There are '.$order->product->quantity.' left in stock and you already have '.$order->quantity.' in your cart.'; 
            return $msg;
        }
        return $msg;
    }

    public function ajaxCartOrderIncrement(Request $request) {
        $request->validate([
            'id' => 'required|exists:orders,id',
        ]);
        $user = Auth::user();
        $updatedorder = new Order();
        $total = 0;
        $cart = $user->cart;
        foreach ($cart->orders as $order) {
            if ($order->id == $request->id) {
                if ($order->quantity + 1 <= $order->product->quantity) {
                    $order->quantity++;
                    $order->save();
                }
                $updatedorder = $order;
            }
            $total += ($order->quantity * $order->product->price);
        }
        $cart->save();
        $data = array($updatedorder->quantity, 
        number_format(($updatedorder->product->price * $updatedorder->quantity), 0, ',', '.'), 
        number_format(($total), 0, ',', '.'));
        return $data;
    }
    public function ajaxCartOrderInput(Request $request) {
        $request->validate([
           'id' => 'required|exists:orders,id',
           'quantity' => 'required|min:0',
        ]);
        $user = Auth::user();
        $updatedorder = new Order();
        $total = 0;
        $cart = $user->cart;
        $condition = true;
        foreach ($cart->orders as $order) {
            if ($order->id == $request->id) {
                if ($request->quantity <= $order->product->quantity) {
                    $order->quantity = $request->quantity;
                    if ($order->quantity <= 0) {
                        $condition = false;
                    }
                    else $order->save();
                }
                if ($condition) {
                    $updatedorder = $order;
                } else continue;
            }
            $total += ($order->quantity * $order->product->price);
        }
        $cart->save();
        $data = null;
        if ($condition) {
            $data = array($updatedorder->quantity, 
            number_format(($updatedorder->product->price * $updatedorder->quantity), 0, ',', '.'), 
            number_format(($total), 0, ',', '.'));
        } else {
            $data = array(null, null, 
            number_format(($total), 0, ',', '.'));
        }
        return $data;
    }
    public function ajaxCartOrderDecrement(Request $request) {
        $request->validate([
           'id' => 'required|exists:orders,id', 
        ]);
        $user = Auth::user();
        $updatedorder = new Order();
        $total = 0;
        $cart = $user->cart;
        foreach ($cart->orders as $order) {
            if ($order->id == $request->id) {
                if ($order->quantity - 1 >= 0) {
                    $order->quantity--;
                    $order->save();
                }
                $updatedorder = $order;
            }
            $total += ($order->quantity * $order->product->price);
        }
        $cart->save();
        $data = array($updatedorder->quantity, 
        number_format(($updatedorder->product->price * $updatedorder->quantity), 0, ',', '.'), 
        number_format(($total), 0, ',', '.'));
        return $data;
    }

    public function delete($id) {
        $order = Order::find($id);
        $order->delete();
        return back();
    }
}
