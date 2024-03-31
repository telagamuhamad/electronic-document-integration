<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderItem;
use App\Models\TravelDocument;
use Illuminate\Http\Request;

class TravelDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $travelDocuments = TravelDocument::orderBy('id', 'desc')->paginate(10);

        return view('admin.travel-document.index', [
            'travel_documents' => $travelDocuments
        ]);
    }

    /**
     * Show the details of travel document
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $travelDocument = TravelDocument::find($id);
        if (empty($travelDocument)) {
            return redirect()->back()->with('error_message', 'Travel document not found');
        }

        return view('admin.travel-document.show', [
            'travel_document' => $travelDocument
        ]);
    }

    /**
     * Show the detail of delivery order
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function showItem($id)
    {
        $deliveryOrder = DeliveryOrder::find($id);
        if (empty($deliveryOrder)) {
            return redirect()->back()->with('error', 'Delivery order not found');
        }

        $deliveryOrderItems = DeliveryOrderItem::where('delivery_order_id', $deliveryOrder->id)->get();

        return view('admin.travel-document.show-item', [
            'delivery_order' => $deliveryOrder,
            'delivery_order_items' => $deliveryOrderItems
        ]);
    }
}
