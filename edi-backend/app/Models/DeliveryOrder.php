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

    protected $table = 'delivery_order_headers';

    protected $fillable = [
        'car_id',
        'travel_document_id',
        'delivery_order_number',
        'sender_name',
        'sender_phone_number',
        'sender_address',
        'receiver_name',
        'receiver_phone_number',
        'receiver_address',
        'total_weight',
        'status',
        'remarks',
        'total_price',
        'last_updated_by_user_id',
        'last_updated_by_user_name',
        'is_delivered',
        'is_paid',
        'payment_method',
        'payment_status'
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

    /**
     * Return relation to Car
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function car()
    {
        return $this->belongsTo(Cars::class, 'car_id', 'id');
    }

    /**
     * Return relation to travel document
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function travelDocument()
    {
        return $this->belongsTo(TravelDocument::class, 'travel_document_id', 'id');
    }

    /**
     * Relation to Invoice
     */
    public function invoice(){
        return $this->hasOne(Invoices::class, 'delivery_order_id', 'id');
    }
}
