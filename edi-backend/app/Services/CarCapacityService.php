<?php

namespace App\Services;

use App\Models\Cars;

class CarCapacityService 
{
    public static function countCarCapacity($carId, $totalItemWeight)
    {
        $car = Cars::find($carId);
        if (!empty($car)) {
            $car->capacity = $car->capacity - $totalItemWeight;

            // update car capacity based on total item weight
            $car->is_fulfilled = $car->capacity <= 0 ? 1 : 0;
            $car->save();
        }
    }
}