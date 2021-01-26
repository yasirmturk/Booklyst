<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    const STATUS_BOOKED = 'BOOKED';
    const STATUS_INPROGRESS = 'INPROGRESS';
    const STATUS_COMPLETED = 'COMPLETED';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
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
        'id', 'created_at', 'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'service_time' => 'datetime',
    ];

    /**
     * Get associated Service
     * @return \App\Models\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get associated Service
     * @return \App\Models\Service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
