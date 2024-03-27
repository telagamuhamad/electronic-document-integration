<?php

namespace App\Services;

use App\Models\Cars;

class CarCapacityService 
{
    public function countCarCapacity($carId)
    {
        $car = Cars::find($carId);
        if (!empty($car)) {
            $carCapacity = $car->capacity;
        }
    }
}