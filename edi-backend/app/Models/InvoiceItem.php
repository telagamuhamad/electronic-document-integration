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
        'good_return_note_id',
        'good_return_note_item_id',
        'price',
        'payment_method',
        'is_paid'
    ];

    /**
     * Return relation to Invoice
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(Invoices::class);
    }

    /**
     * Return relation to DeliveryOrderItem
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveryOrderItem()
    {
        return $this->belongsTo(DeliveryOrderItem::class);
    }

    /**
     * Return Relation to GoodReturnNoteItem
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goodReturnNoteItem()
    {
        return $this->belongsTo(GoodReturnNoteItem::class);
    }

    /**
     * setup activity logs
     */
    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
