<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryGroupModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_get_categories_total()
    {
        $user = $this->createUser();
        $budget = $this->createBudget($user);

        $categoryGroup = $budget->categoryGroups()->where('name', 'Family')->first();
        $categoryGroup->categories->each->update(['amount' => '15.000']);
        $this->assertEquals('45.0000', $categoryGroup->categoriesTotal());
    }
}
