<?php

namespace Tests\Feature\Factories;

use App\Factories\CategoryFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryFactoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_create_new_category()
    {
        $user = $this->createUser();
        $budget = $this->createBudget($user);
        $categoryGroup = $budget->categoryGroups()->first();
        (new CategoryFactory)->create($categoryGroup, [
            'name' => 'Groceries',
            'amount' => 100
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Groceries',
            'category_group_id' => $categoryGroup->id,
        ]);
    }
}
