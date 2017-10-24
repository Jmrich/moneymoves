<?php

namespace Tests\Feature\Models;

use App\Models\Budget;
use App\Models\CategoryGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BudgetModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_create_budget()
    {
        $user = factory(User::class)->create();
        $budget = Budget::forceCreate([
            'name' => 'First Budget',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('budgets', [
            'id' => $budget->id,
            'name' => $budget->name,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function can_create_budget_with_multiple_category_groups()
    {
        $user = factory(User::class)->create();
        $budget = Budget::forceCreate([
            'name' => 'First Budget',
            'user_id' => $user->id,
        ]);

        collect(CategoryGroup::DEFAULT_CATEGORY_GROUPS)->each(function ($group) use ($budget) {
            $this->assertDatabaseHas('category_groups', [
                'name' => $group,
                'budget_id' => $budget->id,
            ]);
        });
    }
}
