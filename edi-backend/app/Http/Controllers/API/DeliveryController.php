<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cars;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderItem;
use App\Models\GoodsReceiptHeader;
use App\Models\Invoices;
use App\Models\TravelDocument;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function getItems(Request $request)
    {
        $user = User::where('id', $request->userId)->first();
        if (empty($user)) {
            return response()->json([
                'error' => true,
                'error_message' => 'User tidak ditemukan'
            ]);
        }
        if ($user->role !== 'Kurir') {
            return response()->json([
                'error' => true,
                'error_message' => 'Sorry, you are not authorized to access this resource'
            ]);
        }

        $car = Cars::where('license_plate', $request->license_plate)->first();
        if (empty($car)) {
            return response()->json([
                'error' => true,
                'error_message' => 'Kendaraan tidak ditemukan'
            ]);
        }

        $deliveryOrder = DeliveryOrder::where('delivery_order_number', $request->delivery_order_number)
            ->where('car_id', $car->id)
            ->with(['items', 'invoice'])
            ->first();

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
        $user = User::where('id', $request->userId)->first();
        if (empty($user)) {
            return response()->json([
                'error' => true,
                'error_message' => 'User tidak ditemukan'
            ]);
        }
        if ($user->role !== 'Kurir') {
            return response()->json([
                'error' => true,
                'error_message' => 'Sorry, you are not authorized to access this resource'
            ]);
        }

        $car = Cars::where('license_plate', $request->license_plate)->first();
        if (empty($car)) {
            return response()->json([
                'error' => true,
                'error_message' => 'Kendaraan tidak ditemukan'
            ]);
        }

        $deliveryOrder = DeliveryOrder::where('delivery_order_number', $request->delivery_order_number)
            ->where('car_id', $car->id)
            ->first();

        if (empty($deliveryOrder)) {
            return response()->json([
                'error' => true,
                'error_message' => 'Pesanan tidak ditemukan'
            ]);
        }

        $goodsReceipt = GoodsReceiptHeader::where('delivery_order_id', $deliveryOrder->id)->first();
        if (empty($goodsReceipt)) {
            return response()->json([
                'error' => true,
                'error_message' => 'Tanda Terima Pesanan tidak ditemukan'
            ]);
        }

        $invoice = Invoices::where('delivery_order_id', $deliveryOrder->id)->first();
        if (empty($invoice)) {
            return response()->json([
                'error' => true,
                'error_message' => 'Invoice Pesanan tidak ditemukan'
            ]);
        }

        try {
            // Save car
            $car->is_delivered = true;
            // Save delivery order
            $deliveryOrder->status = 'Diterima';
            $deliveryOrder->is_received = true;

            // Save goods receipt
            $goodsReceipt->received_date = Carbon::now();
            $goodsReceipt->is_delivered = true;

            // Save invoice
            $invoice->received_date = Carbon::now();
            $invoice->is_delivered = true;

            // if (!$deliveryOrder->is_paid) {
                $deliveryOrder->payment_method = $request->payment_method;
                $deliveryOrder->is_paid = true;
                $deliveryOrder->payment_status = 'Paid';

                // Save Goods Receipt
                $goodsReceipt->payment_method = $request->payment_method;
                $goodsReceipt->is_paid = true;
                $goodsReceipt->payment_status = 'Paid';

                // Save Invoice
                $invoice->payment_method = $request->payment_method;
                $invoice->is_paid = true;
                $invoice->payment_status = 'Paid';
                $path = null;
                if ($request->payment_method == 'Tunai') {
                    $invoice->paid_amount = $request->paid_amount;
                    $invoice->payment_change = $request->payment_change;
                    $invoice->payment_date = Carbon::now();
                }

                if ($request->payment_method === 'Transfer' && $request->hasFile('payment_image')) {
                    $file = $request->file('payment_image');
                    $filename = $file->getClientOriginalName();
                    $file->storeAs('invoice/payment_upload', $filename, 'public');
                    // $file->move('invoice/payment_upload', $filename); // Simpan file gambar ke direktori yang diinginkan
                    $invoice->payment_document = 'invoice/payment_upload/' . $filename; // Simpan path file gambar di database
                }
            // }
            $car->save();
            $deliveryOrder->save();
            $goodsReceipt->save();
            $invoice->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'error_message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'error' => false,
            'success_message' => 'Status pesanan berhasil diubah'
        ]);
    }
}
