<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Courier extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'couriers';

    protected $fillable = [
        'name_1',
        'name_2',
        'car_id',
        'status'  
    ];

    /**
     * setup activity logs
     */
    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    /**
     * Relation to Car
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function car()
    {
        return $this->belongsTo(Cars::class, 'car_id', 'id');
    }
}
