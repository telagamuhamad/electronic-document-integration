<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GoodsReceiptHeader extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'goods_receipt_headers';

    protected $fillable = [
        'delivery_order_id',
        'goods_receipt_number',
        'sender_name',
        'sender_address',
        'receiver_name',
        'receiver_address',
        'total_cost',
        'delivery_date',
        'received_date',
        'total_items',
        'last_updated_by_user_id',
        'last_updated_by_user_name',
        'is_delivered',
        'is_paid',
        'payment_method',
        'payment_status'
    ];

    /**
     * setup activity logs
     */
    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    /**
     * Returns relation to Delivery Order
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveryOrder()
    {
        return $this->belongsTo(DeliveryOrder::class, 'delivery_order_id');
    }

    /**
     * Returns relation to goods receipt items
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(GoodsReceiptItem::class, 'goods_receipt_id');
    }
}
