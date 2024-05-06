<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cars;
use App\Models\DeliveryOrder;
use App\Models\GoodsReceiptHeader;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function getCar(Request $request)
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

        $car = Cars::where('license_plate', $request->license_plate)->with('deliveryOrders')->first();
        if (empty($car)) {
            return response()->json([
                'error' => true,
                'error_message' => 'Car not found.'
            ]);
        }

        return response()->json([
            'error' => false,
            'car' => $car
        ]);
    }

    public function updateCarStatus(Request $request)
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
                'error_message' => 'Car not found.'
            ]);
        }

        $deliveryOrders = DeliveryOrder::where('car_id', $car->id)->get();

        if ($request->status === 'Berangkat') {
            $car->is_departed = true;
            if (!empty($deliveryOrders)) {
                foreach ($deliveryOrders as $deliveryOrder) {
                    $deliveryOrder->status = $request->status;
                    $deliveryOrder->is_delivered = true;
                    $deliveryOrder->last_updated_by_user_id = $user->id;
                    $deliveryOrder->last_updated_by_user_name = $user->name;

                    $goodsReceipts = GoodsReceiptHeader::where('delivery_order_id', $deliveryOrder->id)->first();
                    if (empty($goodsReceipts)) {
                        return response()->json([
                            'error' => true,
                            'error_message' => 'Goods receipt not found.'
                        ]);
                    }
                    $goodsReceipts->delivery_date = Carbon::now();
                    $goodsReceipts->is_delivered = true;
                    $goodsReceipts->last_updated_by_user_id = $user->id;
                    $goodsReceipts->last_updated_by_user_name = $user->name;

                    $goodsReceipts->save();
                    $deliveryOrder->save();
                }
            }
        } else if ($request->status == 'Terkendala') {
            if (!empty($deliveryOrders)) {
                foreach ($deliveryOrders as $deliveryOrder) {
                    $deliveryOrder->status = $request->status;
                    $deliveryOrder->last_updated_by_user_id = $user->id;
                    $deliveryOrder->last_updated_by_user_name = $user->name;
                    $deliveryOrder->save();
                }
            }
        }
        $car->save();

        return response()->json([
            'error' => false,
            'success_message' => 'Car status has been updated.'
        ]);
    }
}
