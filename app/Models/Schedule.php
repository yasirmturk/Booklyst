<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'mon', 'mon_start', 'mon_stop',
        'tue', 'tue_start', 'tue_stop',
        'wed', 'wed_start', 'wed_stop',
        'thu', 'thu_start', 'thu_stop',
        'fri', 'fri_start', 'fri_stop',
        'sat', 'sat_start', 'sat_stop',
        'sun', 'sun_start', 'sun_stop',
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'id', 'schedulable_type', 'schedulable_id',
        'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'mon' => 'boolean',
        'mon_start' => 'datetime:H:i',
        'mon_stop' => 'datetime:H:i',
        'tue' => 'boolean',
        'tue_start' => 'datetime:H:i',
        'tue_stop' => 'datetime:H:i',
        'wed' => 'boolean',
        'wed_start' => 'datetime:H:i',
        'wed_stop' => 'datetime:H:i',
        'thu' => 'boolean',
        'thu_start' => 'datetime:H:i',
        'thu_stop' => 'datetime:H:i',
        'fri' => 'boolean',
        'fri_start' => 'datetime:H:i',
        'fri_stop' => 'datetime:H:i',
        'sat' => 'boolean',
        'sat_start' => 'datetime:H:i',
        'sat_stop' => 'datetime:H:i',
        'sun' => 'boolean',
        'sun_start' => 'datetime:H:i',
        'sun_stop' => 'datetime:H:i',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    public static $rules = [
        'mon' => 'boolean',
        'mon_start' => 'date_format:H:i',
        'mon_stop' => 'date_format:H:i',
        'tue' => 'boolean',
        'tue_start' => 'date_format:H:i',
        'tue_stop' => 'date_format:H:i',
        'wed' => 'boolean',
        'wed_start' => 'date_format:H:i',
        'wed_stop' => 'date_format:H:i',
        'thu' => 'boolean',
        'thu_start' => 'date_format:H:i',
        'thu_stop' => 'date_format:H:i',
        'fri' => 'boolean',
        'fri_start' => 'date_format:H:i',
        'fri_stop' => 'date_format:H:i',
        'sat' => 'boolean',
        'sat_start' => 'date_format:H:i',
        'sat_stop' => 'date_format:H:i',
        'sun' => 'boolean',
        'sun_start' => 'date_format:H:i',
        'sun_stop' => 'date_format:H:i',
    ];

    /**
     * Get the owning scheduleable model.
     */
    public function scheduleable(): MorphTo
    {
        return $this->morphTo();
    }
}
