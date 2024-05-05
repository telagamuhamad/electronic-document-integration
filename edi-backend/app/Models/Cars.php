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
        'is_departed',
        'is_delivered',
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
        $status = null;
        if (!$this->is_departed && !$this->is_fulfilled) {
            $status = 'Memuat';
        } else if ($this->is_fulfilled && !$this->is_departed) {
            $status = 'Penuh';
        }

        return $status;
    }

    /**
     * Get Formatted Departure Status
     * @return string
     */
    public function getFormattedDepartureStatusAttribute()
    {
        if ($this->is_departed && $this->is_delivered) {
            return 'Selesai Mengirim';
        } else if ($this->is_departed && !$this->is_delivered) {
            return 'Dalam Perjalanan';
        } else {
            return 'Belum Berangkat';
        }
    }

    /**
     * Generate QR Code
     */
    public function getQrCodeAttribute()
    {
        $licensePlate = $this->license_plate;

        return FacadesQrCode::size(200)->generate($licensePlate);
    }

    /**
     * Relation to Delivery orders
     */
    public function deliveryOrders()
    {
        return $this->hasMany(DeliveryOrder::class, 'car_id', 'id');
    }
}
