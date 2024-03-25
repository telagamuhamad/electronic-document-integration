<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GoodReturnNoteItem extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'good_return_note_items';

    protected $fillable = [
        'good_return_note_id',
        'good_return_note_number',
        'delivery_order_id',
        'delivery_order_item_id',
        'product_name',
        'product_desription',
        'product_price',
        'delivery_to_address',
        'delivery_to_name',
        'status'    
    ];

    /**
     * Return relation to Good Return Notes
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goodReturnNote()
    {
        return $this->belongsTo(GoodReturnNotes::class, 'good_return_note_id');
    }

    /**
     * Return relation to Delivery Orders
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveryOrder()
    {
        return $this->belongsTo(DeliveryOrder::class, 'delivery_order_id');
    }

    /**
     * Relation to Delivery Order Items
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveryOrderItem()
    {
        return $this->belongsTo(DeliveryOrderItem::class, 'delivery_order_item_id');
    }

    /**
     * setup activity logs
     */
    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
