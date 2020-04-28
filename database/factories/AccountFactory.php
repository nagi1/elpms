<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Account;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
    ];
});
