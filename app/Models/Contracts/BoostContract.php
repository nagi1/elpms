<?php

namespace App\Models\Contracts;

use App\User;
use App\Models\Boost;


interface BoostContract
{
    public function getBoostsCount(): int;
    public function boost(User $user, array $attributes): Boost;
}
