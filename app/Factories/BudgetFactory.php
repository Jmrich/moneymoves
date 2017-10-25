<?php

namespace App\Factories;

use App\Models\Budget;
use App\Models\CategoryGroup;
use App\Models\User;

class BudgetFactory
{
    public const DEFAULT_GROUPS_AND_CATEGORIES = [
        'Family' => [
            'Daycare',
            'Children Clothing',
            'Family Outings'
        ],
        'Savings' => [
            'Emergency Fund',
            'Vacation',
        ],
        'Debt Payments' => [
            'Car Payment',
            'Credit Cards',
            'Student Loans',
        ],
        'Entertainment' => [
            'Concert',
            'Movies',
        ],
        'Home Entertainment' => [
            'Netflix',
            'Amazon',
            'Hulu',
        ],
        'Investment' => [
            '401k',
            'Stocks/Bonds'
        ],
    ];

    public function create(User $user, string $name): Budget
    {
        $budget = Budget::forceCreate([
            'name' => $name,
            'user_id' => $user->id,
        ]);

        collect(self::DEFAULT_GROUPS_AND_CATEGORIES)
            ->each(function ($categories, $name) use ($budget) {
                $categoryGroup = $budget->categoryGroups()->create([
                    'name' => $name
                ]);

                collect($categories)->each(function ($category) use ($categoryGroup) {
                    $categoryGroup->categories()->create([
                        'name' => $category
                    ]);
                });
            });

        return $budget;
    }
}