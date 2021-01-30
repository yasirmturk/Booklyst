<?php

namespace App\Models;

use App\Traits\Wishable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Wishable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'business_id', 'price', 'discount', 'description'
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
     * Also expand
     */
    protected $with = ['images'];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'price' => 'required|min:0',
        'discount' => 'integer|min:0|max:100'
    ];

    /**
     * Get associated Business
     * @return \App\Models\Business
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Get the images
     */
    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }
}
