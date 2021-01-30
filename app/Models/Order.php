<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'amount', 'is_paid', 'is_cancelled'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'id', 'created_at', 'updated_at',
    ];

    /**
     * {@inheritdoc}
     */
    protected $with = ['bookings'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'double',
        'is_paid' => 'boolean',
        'is_cancelled' => 'boolean',
    ];

    /**
     * Get the bookings.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get associated User
     * @return \App\Models\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
