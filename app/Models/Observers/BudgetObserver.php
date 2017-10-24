<?php

namespace App\Models\Observers;

use App\Models\Budget;
use App\Models\CategoryGroup;

class BudgetObserver
{
    public function created(Budget $budget)
    {
        collect(CategoryGroup::DEFAULT_CATEGORY_GROUPS)
            ->each(function ($name) use ($budget) {
                $budget->categoryGroups()->create([
                    'name' => $name
                ]);
            });
    }
}