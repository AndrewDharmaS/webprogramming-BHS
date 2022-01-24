<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(!Auth::guest()) {
            $user = Auth::user();
            if ($user->cart == null) {
                $cart = new Cart;
                $cart->user_id = $user->id;
                $cart->save();
            }
        }
        $products = Product::orderBy('id', 'desc')->paginate(8);
        $categories = Category::all();
        $max = Product::all()->count()/8;
        return view('non-auth.index', compact('products', 'categories', 'max'));
    }
    public function fetch_pagination_data(Request $request) {
        if ($request->ajax()) {
            $products = Product::orderBy('id', 'desc')->paginate(8);
            $categories = Category::all();
            return view('non-auth.index_fetch', compact('products', 'categories'));
        }
    }
    public function about()
    {
        return view('non-auth.about');
    }
}
