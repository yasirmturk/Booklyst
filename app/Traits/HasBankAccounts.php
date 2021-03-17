<?php

namespace App\Traits;

use App\Models\BankAccount;

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
