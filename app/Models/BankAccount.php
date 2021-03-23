<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use SoftDeletes;
    use BelongsToUser;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'user_id', 'country_code', 'currency_code', 'account_number', 'sort_code', 'is_default'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at', 'pivot',
    ];
    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    public static $rules = [
        'country_code' => 'required',
        'currency_code' => 'required',
        'account_number' => 'required|numeric',
        'sort_code' => 'required|numeric',
    ];
}
