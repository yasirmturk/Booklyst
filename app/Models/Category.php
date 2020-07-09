<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'is_service', 'is_product'
    ];

    /**
     * Get the associated Users.
     */
    public function businesses()
    {
        return $this->belongsToMany(Business::class)->withTimestamps();
    }
}
