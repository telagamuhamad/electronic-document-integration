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
        'good_return_note_id',
        'total_cost',
        'status'
    ];

    /**
     * setup activity logs
     */
    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
