<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    const TYPE_HOME = 'HOME';
    const TYPE_SHOP = 'SHOP';
    const TYPE_MOBILE = 'MOBILE';
    /**
     * The types that should be allowed.
     *
     * @var array
     */
    public static $types = [
        self::TYPE_HOME, self::TYPE_SHOP, self::TYPE_MOBILE
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'is_service', 'is_product', 'type', 'phone', 'employee_count'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'categories' => 'array',
    ];

    /**
     * Get the business categories.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    /**
     * Get the associated Users.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
