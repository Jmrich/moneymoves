<?php

use App\Models\Income;
use Faker\Generator as Faker;

$factory->define(App\Models\Income::class, function (Faker $faker) {
    $frequency = $faker->randomElement(Income::PAY_PERIODS);

    $startDate = function ($frequency) {
        if (in_array($frequency, ['weekly', 'biweekly', 'monthly', 'annually'])) {
            return date('Y-m-d');
        }

        return array_random([date('Y-m-15'), date('Y-m-30')]);
    };

    return [
        'name' => $faker->word,
        'amount' => $faker->randomFloat(4, 0, 5000),
        'frequency' => $frequency,
        'start_date' => $startDate($frequency),
    ];
});
