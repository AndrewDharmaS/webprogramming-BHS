<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class ProductController extends Controller
{
    //
    public function view($id) {
        $product = Product::find($id);
        $products = Product::orderBy('id', 'desc')->latest()->take(4)->get();
        return view('non-auth.product', compact('product', 'products'));
    }
    
    public function search(Request $request) {
        $request->validate([
            'search' => 'nullable|max:255',
        ]);
        $search = $request->search;
        $products = Product::where([
            ['name', '!=', NULL],
            [function ($query) use ($search) {
                $query->orWhere('name', 'LIKE', '%'.$search.'%');
            }]
        ])->orderBy('id', 'desc')->paginate(40);
        
        return view('non-auth.search', compact('products', 'search'));
    }
    public function productControls() {
        $products = Product::orderBy('id', 'desc')->paginate(25);
        return view('auth.admin.admin-product', compact('products'));
    }
    public function delete($id) {
        $product = Product::find($id);
        if ($product->image != null) {
            $path = 'assets/images/product';
            $image = $product->image;
            $image = $path.'/'.$product->image;
            if (File::exists($image)) {
                File::delete($image);
            }
        }
        $orders = Order::where('product_id', '=', $product->id);
        foreach ($orders as $order) $order->delete();
        $product->delete();
        return back();
    }
    public function productInsert() {
        $categories = Category::all();
        return view('auth.admin.product-create', compact('categories'));
    }
    public function productUpdate($id) {
        $categories = Category::all();
        $product = Product::find($id);
        return view('auth.admin.product-update', compact('categories', 'product'));
    }
    public function create(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'category' => 'required|exists:categories,id',
            'quantity' => 'required|min:0',
            'price' => 'required|min:0',
            'decription' => 'nullable',
            'link' => 'nullable|url|max:255',
            'image' => 'required|image|max:5120|mimes:jpg,jpeg,png,svg|dimensions:min_width:100,min_height:100,max_width:1000,max_height:1000'
        ]);
        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->link = $request->link;
        $file = $request->file('image');
		$image = time()."_".$file->getClientOriginalName();
        $path = 'assets/images/product';
        $file->move($path, $image);
        $product->image = $image;
        $product->save();
        $categories = Category::all();
        return redirect()->back()->with(['status' => 'Product '.$product->name.' Inserted!']);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|max:255',
            'category' => 'required|exists:categories,id',
            'quantity' => 'required|min:0',
            'price' => 'required||min:0',
            'decription' => 'nullable',
            'link' => 'nullable|url|max:255',
            'image' => 'nullable|image|max:5120|mimes:jpg,jpeg,png,svg|dimensions:min_width:100,min_height:100,max_width:1000,max_height:1000'
        ]);
        $product = Product::find($id);
        $oldname = $product->name;
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->link = $request->link;
        if ($request->file('image') != null) {
            $file = $request->file('image');
            $image = time()."_".$file->getClientOriginalName();
            $path = 'assets/images/product';
            $oldimage = $product->image;
            $oldimage = $path.'/'.$product->image;
            if (File::exists($oldimage)) {
                File::delete($oldimage);
            }
            $file->move($path, $image);
            $product->image = $image;
        }
        $product->save();
        $categories = Category::all();
        return redirect()->back()->with(['status' => 'Product '.$oldname.' Updated!']);
    }
}
