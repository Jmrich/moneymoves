<?php

namespace Tests\Feature\Models;

use App\Factories\BudgetFactory;
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
    public function can_get_budget_category_totals()
    {
        $user = $this->createUser();
        $budget = $this->createBudget($user);
        $budget->categoryGroups()->where('name', 'Family')->get()
            ->each(function ($categoryGroup) {
                $categoryGroup->categories->each->update([
                    'amount' => 100,
                ]);
            });

        $this->assertEquals(300, $budget->getCategoriesTotal());
    }
}
