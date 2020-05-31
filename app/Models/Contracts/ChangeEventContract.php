<?php

namespace App\Models\Contracts;

use App\User;
use App\Models\ChangeEvent;


interface ChangeEventContract
{
    public function userDid(array $attributes, User $user): ChangeEvent;
}
