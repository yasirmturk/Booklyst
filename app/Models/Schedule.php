<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    /* Fillable */
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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'scheduleable_type', 'scheduleable_id',
        'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'mon' => 'boolean',
        'tue' => 'boolean',
        'wed' => 'boolean',
        'thu' => 'boolean',
        'fri' => 'boolean',
        'sat' => 'boolean',
        'sun' => 'boolean',
    ];

    /**
     * Rules
     * @return array
     */
    protected static function rules()
    {
        return [
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
    }

    /**
     * Get the owning scheduleable model.
     */
    public function scheduleable()
    {
        return $this->morphTo();
    }
}
