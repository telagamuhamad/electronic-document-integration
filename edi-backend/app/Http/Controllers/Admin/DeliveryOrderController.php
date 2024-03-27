<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Models\DeliveryOrder;
use Carbon\Carbon;
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

    /**
     * Show the form for create new delivery order
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $couriers = Courier::orderBy('id', 'asc')->get();
        $dateNow = Carbon::now()->format('Y-m-d');

        $do_number = 'DO-' . date('Ymd') . '-' . rand(100000, 999999);
        return view('admin.delivery-order.create', [
            'couriers' => $couriers,
            'do_number' => $do_number,
        ]);
    }
    
}
