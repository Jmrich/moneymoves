<?php

namespace Tests\Feature\Factories;

use App\Factories\BudgetFactory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BudgetFactoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_create_budget_with_default_category_groups_and_categories()
    {
        $user = factory(User::class)->create();
        $budget = (new BudgetFactory)->create($user, 'First Budget');

        collect(BudgetFactory::DEFAULT_GROUPS_AND_CATEGORIES)
            ->each(function ($categories, $name) use ($budget) {
                $this->assertDatabaseHas('category_groups', [
                    'name' => $name,
                    'budget_id' => $budget->id,
                ]);

                $categoryGroup = $budget->categoryGroups()->where('name', $name)->firstOrFail();

                collect($categories)
                    ->each(function ($category) use ($budget, $categoryGroup) {
                        $this->assertTrue($categoryGroup->categories()->where('name', $category)->exists());
                    });
            });
    }
}
