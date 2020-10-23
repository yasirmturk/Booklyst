<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Wish;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Wishable
{
    /**
     * Register a deleted model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    abstract public static function deleted($callback);

    /**
     * Define a polymorphic one-to-many relationship.
     *
     * @param string $related
     * @param string $name
     * @param string $type
     * @param string $id
     * @param string $localKey
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    abstract public function morphMany($related, $name, $type = null, $id = null, $localKey = null);

    /**
     * Boot the wishable trait for the model.
     *
     * @return void
     */
    public static function bootWishable()
    {
        static::deleted(function (self $model) {
            $model->wishes()->delete();
        });
    }

    /**
     * Get all attached wishes to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function wishes(): MorphMany
    {
        return $this->morphMany(Wish::class, 'wishable');
    }
}
