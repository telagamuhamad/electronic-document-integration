<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class InvoiceItem extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'invoice_items';

    protected $fillable = [
        'invoice_id',
        'invoice_number',
        'delivery_order_id',
        'delivery_order_item_id',
        'goods_receipt_id',
        'goods_receipt_item_id',
        'total_item',
        'total_weight',
        'total_price',
        'remarks'
    ];

    /**
     * Return relation to Invoice
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(Invoices::class, 'invoice_id');
    }

    /**
     * Return relation to Delivery Order
     * 
     */
    public function deliveryOrder()
    {
        return $this->belongsTo(DeliveryOrder::class, 'delivery_order_id');
    }

    /**
     * Return relation to Goods Receipt
     * 
     */
    public function goodsReceipt()
    {
        return $this->belongsTo(GoodsReceiptHeader::class, 'goods_receipt_id');
    }

    /**
     * Return relation to DeliveryOrderItem
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveryOrderItem()
    {
        return $this->belongsTo(DeliveryOrderItem::class, 'delivery_order_item_id');
    }

    /**
     * Return relation to GoodsReceiptItem
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goodsReceiptItem()
    {
        return $this->belongsTo(GoodsReceiptItem::class, 'goods_receipt_item_id');
    }

    /**
     * setup activity logs
     */
    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
    
}
