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
        'created_at', 'updated_at',
    ];
    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'is_default' => 'boolean',
    ];
}

/**
 * Has Bank accounts
 */
trait HasBankAccounts
{
    /**
     * Get the Bank accounts.
     */
    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }
}
