<?php

namespace App\Models\Concerns;

use App\User;
use App\Models\Boost;


interface Boostable
{
    public function getBoostsCount(): int;
    public function boost(User $user, array $attributes): Boost;
}
