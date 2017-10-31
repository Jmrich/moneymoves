<?php

namespace Tests;

use App\Factories\BudgetFactory;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function createUser(array $attributes = []): User
    {
        return factory(User::class)->create($attributes);
    }

    protected function createBudget(User $user, $name = 'New Budget')
    {
        return (new BudgetFactory)->create($user, $name);
    }
}
