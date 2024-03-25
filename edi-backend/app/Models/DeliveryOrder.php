<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class DeliveryOrder extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'delivery_orders';

    protected $fillable = [
        'curier_id',
        'storage_location_id',
        'delivery_order_number',
        'delivery_date',
        'delivery_order_status',
        'delivery_type',
        'total_cost',
        'created_by_user_id',
        'created_by_user_name'
    ];

    /**
     * Return relation to Delivery Order items
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(DeliveryOrderItem::class, 'delivery_order_id', 'id');
    }

    /**
     * setup activity logs
     */
    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

}
