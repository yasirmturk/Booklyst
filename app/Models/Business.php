<?php

namespace App\Models;

use App\Traits\Schedulable;
use Illuminate\Database\Eloquent\Model;
use Rinvex\Addresses\Traits\Addressable;

class Business extends Model
{
    use Addressable, Schedulable;

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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'pivot',
    ];

    /**
     * Also expand
     */
    protected $with = ['images', 'addresses', 'schedule'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_service' => 'boolean',
        'is_product' => 'boolean',
        'employee_count' => 'int'
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'is_service' => 'required|boolean',
        'is_product' => 'required|boolean',
        'type' => 'required|in:' . self::TYPE_HOME . ',' . self::TYPE_SHOP . ',' . self::TYPE_MOBILE,
        'employee_count' => 'integer',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|min:7|max:15',
        'categories' => 'required|array|min:1'
    ];

    public function dp($appendingPath = '')
    {
        $image = $this->images->first();
        if ($image) {
            return $appendingPath . $image->filename;
        }
        return null;
    }

    public function address()
    {
        $address = $this->addresses()->first();
        if ($address) {
            return $address->street . ', ' . $address->city . ', ' . $address->country;
        }
        return null;
    }

    /**
     * Get the images
     */
    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }

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

    /**
     * Get the services
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get the products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
