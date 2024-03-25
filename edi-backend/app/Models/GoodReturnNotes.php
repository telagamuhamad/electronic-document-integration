<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GoodReturnNotes extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'good_return_notes';

    protected $fillable = [
        'delivery_order_id',
        'delivery_order_number',
        'good_return_note_number',
        'delivery_date',
        'delivery_from',
        'delivery_to',
        'total_cost',
        'status'
    ];

    /**
     * Return relation to Delivery Order
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
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
