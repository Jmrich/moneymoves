<?php

namespace Tests\Feature\Factories;

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
        $categoryGroup->categories()->create([
            'name' => 'Groceries',
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Groceries',
            'category_group_id' => $categoryGroup->id,
        ]);
    }
}
