<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Wish extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = ['wishable_id', 'wishable_type', 'user_id'];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'wishable_id' => 'integer',
        'wishable_type' => 'string',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [
        'wishable_id' => 'required|integer',
        'wishable_type' => 'required|string|strip_tags|max:150',
    ];

    /**
     * Get associated User.
     * @return \App\Models\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the owner model of the wish.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function wishable(): MorphTo
    {
        return $this->morphTo('wishable', 'wishable_type', 'wishable_id', 'id');
    }
}
