<?php

namespace App\Models\Contracts;

use App\User;
use App\Models\Event;


interface EventContract
{
    public function userDid(array $attributes, User $user): Event;
}
