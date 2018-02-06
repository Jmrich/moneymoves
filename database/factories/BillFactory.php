<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Bill::class, function (Faker $faker) {
    $now = now();
    $dueDate = $now->copy()->addMonth()->day(array_random(range(1, $now->daysInMonth)));
    return [
        'name' => $faker->word,
        'amount' => $faker->randomFloat(4, 0, 5000),
        'due_date' => $dueDate,
    ];
});
