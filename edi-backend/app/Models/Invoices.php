<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Invoices extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'invoices';

    protected $fillable = [
        'delivery_order_id',
        'goods_receipt_id',
        'invoice_number',
        'total_cost',
        'payment_method',
        'payment_status',
        'is_paid',
        'is_delivered',
        'delivery_date',
        'received_date'
    ];

    protected $appends = [
        'formatted_delivery_status',
        'formatted_payment_status'
    ];

    /**
     * setup activity logs
     */
    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults();
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
     * Returns relation to items
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    /**
     * Return formatted delivery status
     */
    public function getFormattedDeliveryStatusAttribute()
    {
        if ($this->is_delivered) {
            return 'Telah Diterima';
        } else {
            return 'Belum Diterima';
        }
    }

    /**
     * Return formatted payment status
     */
    public function getFormattedPaymentStatusAttribute()
    {
        if ($this->is_paid) {
            return 'Lunas';
        } else {
            return 'Belum Lunas';
        }
    }

    /**
     * Return formatted payment method
     */
    public function getFormattedPaymentMethodAttribute()
    {
        if ($this->payment_method == 'Tunai') {
            return 'Tunai';
        } else {
            return 'Transfer';
        }
    }
}
