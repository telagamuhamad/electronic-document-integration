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
        'type',
        'vin_nummber',
        'license_plate_number',
        'capacity',
        'is_available',
        'is_full'
    ];

    /**
     * setup activity logs
     */
    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
