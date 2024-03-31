<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class DeliveryOrderItem extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'delivery_order_items';

    protected $fillable = [
        'delivery_order_id',
        'item_code',
        'item_weight',
        'item_price',
        'description',
        'is_fragile'
    ];

    /**
     * Returns relation to Delivery Order
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 
     */
    public function deliveryOrder()
    {
        return $this->belongsTo(DeliveryOrder::class, 'delivery_order_id', 'id');
    }

    /**
     * setup activity logs
     */
    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
