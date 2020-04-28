<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\User;
use App\Models\Account;

class AccountUser extends Pivot
{
    public $incrementing = true;

    protected $table = 'account_participants';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
