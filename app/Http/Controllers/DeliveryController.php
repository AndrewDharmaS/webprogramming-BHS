<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Delivery;

class DeliveryController extends Controller
{
    //
    public function deliveryControls() {
        $deliveries = Delivery::orderBy('id', 'desc')->paginate(25);
        return view('auth.admin.admin-delivery', compact('deliveries'));
    }
    public function deliveryUpdate($id) {
        $delivery = Delivery::find($id);
        return view('auth.admin.delivery-update', compact('delivery'));
    }
    public function delete($id) {
        $delivery = Delivery::find($id);
        $delivery->delete();
        return back();
    }
    public function create(Request $request) {
        $request->validate([
           'name' => 'required|max:255',
        ]);
        $delivery = new Delivery();
        $delivery->name = $request->name;
        $delivery->save();
        return redirect()->back()->with(['status' => 'Delivery '.$delivery->name.' Inserted!']);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|max:255'
        ]);
        $delivery = Delivery::find($id);
        $oldname = $delivery->name;
        $delivery->name = $request->name;
        $delivery->save();
        return redirect()->back()->with(['status' => 'Delivery '.$oldname.' Updated!']);
    }
}
