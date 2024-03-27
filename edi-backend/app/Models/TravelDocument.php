<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TravelDocument extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'travel_documents';

    protected $fillable = [
        'car_id',
        'delivery_order_id',
        'travel_document_number',
        'delivery_date'
    ];

    /**
     * setup activity logs
     */
    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    /**
     * Return relation to car
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function car()
    {
        return $this->belongsTo(Cars::class, 'car_id', 'id');
    }

    /**
     * Return relation to delivery order
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deliveryOrder()
    {
        return $this->hasMany(DeliveryOrder::class, 'travel_document_id', 'id');
    }
}
