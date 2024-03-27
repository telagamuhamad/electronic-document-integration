<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cars;
use App\Models\Courier;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderItem;
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
        $cars = Cars::orderBy('id', 'asc')->get();
        $dateNow = Carbon::now()->format('Y-m-d');

        $do_number = 'DO-' . date('Ymd') . '-' . rand(100000, 999999);
        return view('admin.delivery-order.create', [
            'do_number' => $do_number,
            'cars' => $cars
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $validations = [
            'resi' => 'required',
            'sender_name' => 'required',
            'sender_phone' => 'required',
            'sender_address' => 'required',
            'receiver_name' => 'required',
            'receiver_phone' => 'required',
            'receiver_address' => 'required',
            'total_item' => 'required',
            'total_weight' => 'required',
            'car_id' => 'required',
            'total_cost' => 'required'
        ];

        $this->validate($request, $validations);

        try {
            $deliveryOrder = new DeliveryOrder();
            $deliveryOrder->delivery_order_number = $request->resi;
            $deliveryOrder->sender_name = $request->sender_name;
            $deliveryOrder->sender_phone_number = $request->sender_phone;
            $deliveryOrder->sender_address = $request->sender_address;
            $deliveryOrder->receiver_name = $request->receiver_name;
            $deliveryOrder->receiver_phone_number = $request->receiver_phone;
            $deliveryOrder->receiver_address = $request->receiver_address;
            $deliveryOrder->status = 'Pending Delivery';
            $deliveryOrder->last_updated_by_user_id = $user->id;
            $deliveryOrder->last_updated_by_user_name = $user->name;
            $deliveryOrder->payment_method = !empty($request->payment_method) ? $request->payment_method : null;
            $deliveryOrder->payment_status = 'Pending Payment';
            $deliveryOrder->save();

            // Save items
            $deliveryOrderItem = new DeliveryOrderItem();
            $deliveryOrderItem->delivery_order_id = $deliveryOrder->id;
            $deliveryOrderItem->total_item = $request->total_item;
            $deliveryOrderItem->total_weight = $request->total_weight;
            $deliveryOrderItem->total_price = $request->total_cost;
            $deliveryOrderItem->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', $e->getMessage());
        }
    }
    
}
