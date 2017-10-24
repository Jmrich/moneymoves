<?php

use App\Models\Budget;
use Faker\Generator as Faker;

$factory->define(Budget::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
