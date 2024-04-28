<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cars;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function getCar(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'Kurir') {
            return response()->json([
                'error' => true,
                'error_message' => 'Sorry, you are not authorized to access this resource.'
            ]);
        }

        $car = Cars::where('license_plate', $request->license_plate)->first();
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
        $user = auth()->user();
        if ($user->role !== 'Kurir') {
            return response()->json([
                'error' => true,
                'error_message' => 'Sorry, you are not authorized to access this resource.'
            ]);
        }

        $car = Cars::where('license_plate', $request->license_plate)->first();
        if (empty($car)) {
            return response()->json([
                'error' => true,
                'error_message' => 'Car not found.'
            ]);
        }

        if (!$car->is_departed) {
            $car->is_departed = true;
            $car->save();

            return response()->json([
                'error' => false,
                'success_message' => 'Car has been departed.'
            ]);
        }
    }
}
