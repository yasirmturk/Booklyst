<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    const STATUS_BOOKED = 'BOOKED';
    const STATUS_INPROGRESS = 'INPROGRESS';
    const STATUS_COMPLETED = 'COMPLETED';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'user_id', 'service_id', 'service_time', 'amount', 'status', 'is_paid', 'is_cancelled'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'service_time' => 'datetime',
        'amount' => 'double',
        'is_paid' => 'boolean',
        'is_cancelled' => 'boolean',
    ];

    /**
     * Get associated Service
     * @return \App\Models\Service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get associated Order
     * @return \App\Models\Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
