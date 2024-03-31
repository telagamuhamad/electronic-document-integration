<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GoodsReceiptItem extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'goods_receipt_items';

    protected $fillable = [
      'goods_receipt_id',
      'delivery_order_id',
      'delivery_order_item_id',
      'item_code',
      'item_weight',
      'item_price',
      'description',
      'is_fragile'
    ];

    /**
     * setup activity logs
     */
    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    /**
     * Returns relation to goods receipt
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goodsReceipt()
    {
        return $this->belongsTo(GoodsReceiptHeader::class, 'goods_receipt_id');
    }

    /**
     * Returns relation to delivery order
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveryOrder()
    {
        return $this->belongsTo(DeliveryOrder::class, 'delivery_order_id');
    }

    /**
     * Returns relation to delivery order item
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveryOrderItem()
    {
        return $this->belongsTo(DeliveryOrderItem::class, 'delivery_order_item_id');
    }
}
