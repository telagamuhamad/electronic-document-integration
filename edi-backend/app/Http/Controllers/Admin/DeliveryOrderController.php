<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cars;
use App\Models\Courier;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderItem;
use App\Models\GoodsReceiptHeader;
use App\Models\GoodsReceiptItem;
use App\Models\TravelDocument;
use App\Services\CarCapacityService;
use App\Services\EdiConversionService;
use App\Services\TravelDocumentService;
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
        $deliveryOrders = DeliveryOrder::orderBy('id', 'desc')->with('car')->paginate(10);

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

        $deliveryOrderItems = DeliveryOrderItem::where('delivery_order_id', $deliveryOrder->id)->get();

        return view('admin.delivery-order.show', [
            'delivery_order' => $deliveryOrder,
            'delivery_order_items' => $deliveryOrderItems
        ]);
    }

    /**
     * Show the form for create new delivery order
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cars = Cars::where('is_fulfilled', 0)->where('is_departed', 0)->orderBy('id', 'desc')->get();
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
            $deliveryOrder->car_id = $request->car_id;
            $deliveryOrder->total_weight = $request->total_weight;
            $deliveryOrder->total_price = $request->total_cost;
            $deliveryOrder->save();

            // check car to generate travel document
            $travelDocument = TravelDocument::where('car_id', $request->car_id)->first();
            if (empty($travelDocument)) {
                $travelDocument = new TravelDocument();
                $travelDocument->car_id = $request->car_id;
                $travelDocument->delivery_order_id = $deliveryOrder->id;
                $travelDocument->travel_document_number = 'TD-' . date('Ymd') . '-' . rand(100000, 999999);
                $travelDocument->save();
            } else {
                $travelDocument->car_id = $request->car_id;
                $travelDocument->delivery_order_id = $deliveryOrder->id;
                $travelDocument->travel_document_number = $travelDocument->travel_document_number;
                $travelDocument->save();
            }

            $deliveryOrder->travel_document_id = $travelDocument->id;
            $deliveryOrder->save();
    
            // Save items
            $total_cost = 0;
    
            foreach ($request->item_code as $key => $item_code) {
                $deliveryOrderItem = new DeliveryOrderItem();
                $deliveryOrderItem->delivery_order_id = $deliveryOrder->id;
                $deliveryOrderItem->item_code = $item_code;
                $deliveryOrderItem->item_weight = $request->item_weight[$key];
                $deliveryOrderItem->item_price = $request->item_price[$key];
                $deliveryOrderItem->description = $request->description[$key];
                $deliveryOrderItem->is_fragile = isset($request->is_fragile[$key]) ? 1 : 0;
                $deliveryOrderItem->save();
    
                $total_cost += $request->item_price[$key];
            }

            CarCapacityService::countCarCapacity($deliveryOrder->car_id, $deliveryOrder->total_weight);
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', $e->getMessage());
        }

        return redirect()->route('admin.edi.delivery-order.index')->with('success_message', 'Delivery order created successfully');
    }

    /**
     * Convert to Goods Receipt
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function convert(Request $request, $id)
    {
        $user = auth()->user();
        $deliveryOrder = DeliveryOrder::find($id);
        if (empty($deliveryOrder)) {
            return redirect()->back()->with('error_message', 'Delivery order not found');
        }

        $dateNow = Carbon::now()->format('Y-m-d');
        $gr_number = 'GR-' . date('Ymd') . '-' . rand(100000, 999999);
        try {
            $goodsReceiptHeader = new GoodsReceiptHeader();
            $goodsReceiptHeader->delivery_order_id = $deliveryOrder->id;
            $goodsReceiptHeader->goods_receipt_number = $gr_number;
            $goodsReceiptHeader->sender_name = $deliveryOrder->sender_name;
            $goodsReceiptHeader->sender_address = $deliveryOrder->sender_address;
            $goodsReceiptHeader->receiver_name = $deliveryOrder->receiver_name;
            $goodsReceiptHeader->receiver_address = $deliveryOrder->receiver_address;
            $goodsReceiptHeader->total_cost = $deliveryOrder->total_price;
            $goodsReceiptHeader->total_weight = $deliveryOrder->total_weight;
            $goodsReceiptHeader->is_delivered = $deliveryOrder->is_delivered;
            $goodsReceiptHeader->is_paid = $deliveryOrder->is_paid;
            $goodsReceiptHeader->payment_method = $deliveryOrder->payment_method;
            $goodsReceiptHeader->payment_status = $deliveryOrder->payment_status;
            $goodsReceiptHeader->last_updated_by_user_id = $user->id;
            $goodsReceiptHeader->last_updated_by_user_name = $user->name;
            $goodsReceiptHeader->save();
    
            // Save items
            if (!empty ($deliveryOrder->items)) {
                foreach ($deliveryOrder->items as $item) {
                    $goodsReceiptItem = new GoodsReceiptItem();
                    $goodsReceiptItem->goods_receipt_id = $goodsReceiptHeader->id;
                    $goodsReceiptItem->delivery_order_id = $deliveryOrder->id;
                    $goodsReceiptItem->delivery_order_item_id = $item->id;
                    $goodsReceiptItem->item_code = $item->item_code;
                    $goodsReceiptItem->item_weight = $item->item_weight;
                    $goodsReceiptItem->item_price = $item->item_price;
                    $goodsReceiptItem->description = $item->description;
                    $goodsReceiptItem->is_fragile = $item->is_fragile;
                    $goodsReceiptItem->save();
                }
            }

            $deliveryOrder->is_converted = true;
            $deliveryOrder->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', $e->getMessage());
        }

        return redirect()->route('admin.edi.delivery-order.index')->with('success_message', 'Delivery order converted to goods receipt successfully');
    }
    
}
