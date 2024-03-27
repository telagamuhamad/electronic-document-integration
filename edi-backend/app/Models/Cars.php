<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Cars extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'cars';

    protected $fillable = [
        'license_plate',
        'driver_name_1',
        'driver_name_2',
        'capacity',
        'is_fulfilled',
        'is_departed'
    ];

    /**
     * setup activity logs
     */
    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
