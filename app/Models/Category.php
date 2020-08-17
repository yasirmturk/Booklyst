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
        'is_service' => 'boolean',
        'is_product' => 'boolean',
        'image_id' => Image::class,
    ];

    /**
     * Get the image
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * Get the associated Users.
     */
    public function businesses()
    {
        return $this->belongsToMany(Business::class)->withTimestamps();
    }
}
