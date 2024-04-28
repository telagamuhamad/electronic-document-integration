<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderItem;
use App\Models\TravelDocument;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function getData(Request $request) {
        $user = auth()->user();
        if ($user->role !== 'Kurir') {
            return response()->json([
                'error' => true,
                'error_message' => 'Sorry, you are not authorized to access this resource'
            ]);
        }

        $travelDocument = TravelDocument::where('travel_document_number', $request->travel_document_number)->first();
        if (empty($travelDocument)) {
            return response()->json([
                'error' => true,
                'error_message' => 'Dokumen tidak ditemukan'
            ]);
        }

        return response()->json([
            'error' => false,
            'travelDocument' => $travelDocument
        ]);
    }

    public function updateStatus(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'Kurir') {
            return response()->json([
                'error' => true,
                'error_message' => 'Sorry, you are not authorized to access this resource'
            ]);
        }

        $travelDocument = TravelDocument::where('travel_document_number', $request->travel_document_number)->with('deliveryOrders')->first();
        if (empty($travelDocument)) {
            return response()->json([
                'error' => true,
                'error_message' => 'Dokumen tidak ditemukan'
            ]);
        }

        $travelDocument->status = $request->status;
        $travelDocument->save();

        // Update delivery orders status
        if (!empty($travelDocument->deliveryOrders)) {
            foreach ($travelDocument->deliveryOrders as $deliveryOrder) {
                $deliveryOrder->status = $request->status;
                $deliveryOrder->save();
            }       
        }

        return response()->json([
            'error' => false,
            'success_message' => 'Status berhasil diubah'
        ]);
    }

    public function getItems(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'Kurir') {
            return response()->json([
                'error' => true,
                'error_message' => 'Sorry, you are not authorized to access this resource'
            ]);
        }

        $deliveryOrder = DeliveryOrder::where('delivery_order_number', $request->delivery_order_number)->first();
        if (empty($deliveryOrder)) {
            return response()->json([
                'error' => true,
                'error_message' => 'Pesanan tidak ditemukan'
            ]);
        }

        $deliveryOrderItems = DeliveryOrderItem::where('delivery_order_id', $deliveryOrder->id)->get();
        

        return response()->json([
            'error' => false,
            'deliveryOrder' => $deliveryOrder,
            'deliveryOrderItems' => $deliveryOrderItems
        ]);
    }

    public function updateItemStatus(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'Kurir') {
            return response()->json([
                'error' => true,
                'error_message' => 'Sorry, you are not authorized to access this resource'
            ]);
        }

        $deliveryOrder = DeliveryOrder::where('delivery_order_number', $request->delivery_order_number)->first();
        if (empty($deliveryOrder)) {
            return response()->json([
                'error' => true,
                'error_message' => 'Pesanan tidak ditemukan'
            ]);
        }

        $deliveryOrder->status = $request->status;
        $deliveryOrder->save();

        return response()->json([
            'error' => false,
            'success_message' => 'Status pesanan berhasil diubah'
        ]);
    }
}
