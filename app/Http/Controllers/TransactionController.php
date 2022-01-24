<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\Delivery;
use App\Models\Product;
use App\Models\Order;

class TransactionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function view() {
        $user = Auth::user();
        $transactions = $user->transactions;
        $total = 0;
        foreach($transactions as $transaction) $transaction->cart = unserialize($transaction->cart);
        return view('auth.member.transaction', compact('transactions'));
    }
    public function checkout() {
        $user = Auth::user();
        $deliveries = Delivery::all();
        if ($user->cart == null) {
            return redirect()->route('cart-view');
        }
        $cart = $user->cart->orders;
        $total = 0;
        $totalitems = 0;
        foreach ($cart as $order) {
            $total += ($order->product->price * $order->quantity);
            $totalitems += $order->quantity;
        }
        return view('auth.member.checkout', compact('cart', 'deliveries','totalitems'))->with(['total' => $total]);
        
    }
    public function create(Request $request) {
        $request->validate([
            'delivery' => 'required|exists:deliveries,id',
        ]);
        $user = Auth::user();
        $delivery = Delivery::find($request->delivery);
        $cart = $user->cart;
        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $array = [];
        foreach($cart->orders as $order) {
            $str = ['id' => $order->product->id, 'name' => $order->product->name, 'price' => $order->product->price, 'quantity' => $order->quantity];
            array_push($array, $str);
            $reduce = Product::find($order->product->id);
            $reduce->quantity -= $order->quantity;
            $updateorders = Order::where('product_id', '=', $reduce->id);
            foreach($updateorders as $updating) {
                if ($updating->quantity < $reduce->quantity) $updating->delete();
            }
            $reduce->save();
            $order->delete();
        }
        $transaction->cart = serialize($array);
        $transaction->delivery = $delivery->name;
        $transaction->delivery = $delivery->name;
        $transaction->save();
        $cart->delete();
        $newcart = new Cart();
        $newcart->user_id = $user->id;
        $newcart->save();
        $user->save();
        return redirect()->route('transaction-view');
    }
    public function uploadProof(Request $request, $id) {
        $transaction = Transaction::find($id);
        $request->validate([
            'proof' => 'required|image|max:10240|mimes:jpg,jpeg,png,svg'
        ]);
        
        $file = $request->file('proof');
		$proof = time()."_".$file->getClientOriginalName();
        $path = 'assets/images/transaction';
        if ($transaction != null) {
            $oldimage = $path.'/'.$transaction->image;
            if (File::exists($oldimage)) {
                File::delete($oldimage);
            }
        }
        $file->move($path, $proof);
        $transaction->status = 'waiting';
        $transaction->proof = $proof;
        $transaction->save();
        return redirect()->back();
    }

    public function transactionControls() {
        $transactions = Transaction::orderBy('updated_at', 'desc')->paginate(20);
        return view('auth.admin.admin-transaction', compact(['transactions']));
    }
    public function decline($id) {
        $transaction = Transaction::find($id);
        if ($transaction->proof != null) {
            $path = 'assets/images/transaction';
            $image = $transaction->proof;
            $image = $path.'/'.$transaction->proof;
            if (File::exists($image)) {
                File::delete($image);
            }
        }
        $transaction->status = 'declined';
        $transaction->save();
        return redirect()->back();
    }

    public function accept($id) {
        $transaction = Transaction::find($id);
        $transaction->status = 'accepted';
        $transaction->save();
        return redirect()->back();
    }
    public function cancel($id) {
        $transaction = Transaction::find($id);
        if ($transaction->proof != null) {
            $path = 'assets/images/transaction';
            $image = $transaction->proof;
            $image = $path.'/'.$transaction->proof;
            if (File::exists($image)) {
                File::delete($image);
            }
        }
        $cart = unserialize($transaction->cart);
        foreach ($cart as $c) {
            $product = Product::where('id', '=', $c['id'])->first();
            if ($product != null) {
                $product->quantity += $c['quantity'];
                $product->save();
            }
        }
        $transaction->status = 'canceled';
        $transaction->save();
        return redirect()->back();
    }
}
