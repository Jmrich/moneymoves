<?php

namespace Tests\Feature\Models;

use App\Models\Income;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_get_next_income_amount_from_multiple_sources()
    {
        Carbon::setTestNow('2017-10-27');
        $user = $this->createUser();
        $income1 = $this->createIncome($user, [
            'amount' => 2200.00,
            'start_date' => '2017-10-18',
            'frequency' => 'biweekly',
        ]);
        $income2 = $this->createIncome($user, [
            'amount' => 900.00,
            'start_date' => '2017-09-30',
            'frequency' => 'monthly'
        ]);

        $total = $user->getNextIncomeAmount();
        $this->assertEquals(3100.00, $total);

        Carbon::setTestNow();
    }

    /** @test */
    public function can_get_next_income_date()
    {
        Carbon::setTestNow('2017-10-27');
        $user = $this->createUser();
        $income1 = $this->createIncome($user, [
            'amount' => 2200.00,
            'start_date' => '2017-10-18',
            'frequency' => 'biweekly',
        ]);
        $income2 = $this->createIncome($user, [
            'amount' => 900.00,
            'start_date' => '2017-09-30',
            'frequency' => 'monthly'
        ]);

        $date = $user->getNextIncomeDate();
        $this->assertEquals('2017-10-30', $date->format('Y-m-d'));

        Carbon::setTestNow();
    }

    private function createIncome(User $user, array $attributes = []): Income
    {
        return factory(Income::class)->create([
            'user_id' => $user->id,
        ] + $attributes);
    }
}
