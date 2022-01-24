<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    //
    public function view($id) {
        $categories = Category::all();
        $category = Category::find($id);
        $products = $category->products()->orderBy('id', 'desc')->paginate(40);
        
        return view('non-auth.categories', compact('categories', 'category', 'products'));
    }
    public function categoryControls() {
        $categories = Category::orderBy('id', 'desc')->paginate(25);
        return view('auth.admin.admin-category', compact('categories'));
    }
    public function categoryUpdate($id) {
        $category = Category::find($id);
        return view('auth.admin.category-update', compact('category'));
    }
    public function delete($id) {
        $category = Category::find($id);
        $products = $category->products;
        if ($products != null) {
            foreach ($products as $product) {
                $orders = Order::where('product_id', '=', $product->id);
                foreach ($orders as $order) $order->delete();
                if ($product->image != null) {
                    $path = 'assets/images/product';
                    $image = $product->image;
                    $image = $path.'/'.$product->image;
                    if (File::exists($image)) {
                        File::delete($image);
                    }
                }
                $product->delete();
            }
        }
        $category->delete();
        return back();
    }
    public function create(Request $request) {
        $request->validate([
           'name' => 'required|max:255',
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return redirect()->back()->with(['status' => 'Category '.$category->name.' Inserted!']);
    }
    public function update(Request $request, $id) {
        $request->validate([
           'name' => 'required|max:255',
        ]);
        $category = Category::find($id);
        $oldname = $category->name;
        $category->name = $request->name;
        $category->save();
        return redirect()->back()->with(['status' => 'Category '.$oldname.' Updated!']);
    }
}
