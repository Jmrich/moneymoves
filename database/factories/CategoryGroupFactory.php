<?php

use App\Models\CategoryGroup;
use Faker\Generator as Faker;

$factory->define(CategoryGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
