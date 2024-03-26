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
}
