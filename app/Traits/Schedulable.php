<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Schedulable
{
    /**
     * Boot the schedulable trait for the model.
     *
     * @return void
     */
    public static function bootSchedulable()
    {
        static::deleted(function (self $model) {
            $model->schedule()->delete();
        });
    }

    /**
     * Get attached schedulable to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function schedule(): MorphOne
    {
        return $this->morphOne(Schedule::class, 'schedulable');
    }
}
