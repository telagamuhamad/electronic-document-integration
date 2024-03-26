<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryOrder;
use Illuminate\Http\Request;

class DeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveryOrders = DeliveryOrder::orderBy('id', 'desc')->paginate(10);

        return view('admin.delivery-order.index', [
            'deliveryOrders' => $deliveryOrders
        ]);
    }

    /**
     * Show the detail of delivery order
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deliveryOrder = DeliveryOrder::find($id);
        if (empty($deliveryOrder)) {
            return redirect()->back()->with('error', 'Delivery order not found');
        }

        return view('admin.delivery-order.show', [
            'deliveryOrder' => $deliveryOrder
        ]);
    }
    
}
