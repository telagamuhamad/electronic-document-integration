<?php

namespace App\Models;

use BaconQrCode\Encoder\QrCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SimpleSoftwareIO\QrCode\Facades\QrCode as FacadesQrCode;
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

    protected $appends = [
        'formatted_capacity_status',
        'formatted_departure_status',
        'qr_code'
    ];

    /**
     * setup activity logs
     */
    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    /**
     * Get formatted capacity status
     * @return string
     */
    public function getFormattedCapacityStatusAttribute()
    {
        return $this->is_fulfilled ? 'Penuh' : 'Memuat';
    }

    /**
     * Get Formatted Departure Status
     * @return string
     */
    public function getFormattedDepartureStatusAttribute()
    {
        return $this->is_departed ? 'Dalam Perjalanan' : 'Belum Berangkat';
    }

    /**
     * Generate QR Code
     */
    public function getQrCodeAttribute()
    {
        $licensePlate = $this->license_plate;

        return FacadesQrCode::size(200)->generate($licensePlate);
    }
}
