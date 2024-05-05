<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function landing(Request $request) 
    {
        $deliveryOrder = null;
        if (!empty($request->resi)) {
            $deliveryOrder = DeliveryOrder::where('delivery_order_number', $request->resi)->first();
        }
        return view('landing', [
            'delivery_order' => $deliveryOrder
        ]);
    }

    public function index() 
    {
        $user = auth()->user();
        return view('admin.index', [
            'user' => $user
        ]);
    }
}
