<?php

namespace App\Models;

use App\Traits\Wishable;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use Wishable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'business_id', 'duration', 'price', 'discount'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'business_id', 'created_at', 'updated_at',
    ];

    /**
     * Get associated Business
     * @return \App\Models\Business
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
