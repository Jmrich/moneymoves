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

    /** @test */
    public function can_get_income_for_month()
    {
        Carbon::setTestNow('2017-10-01');
        $user = $this->createUser();
        $income1 = $this->createIncome($user, [
            'amount' => 2200.00,
            'start_date' => '2017-10-04',
            'frequency' => 'biweekly',
        ]);
        $income2 = $this->createIncome($user, [
            'amount' => 900.00,
            'start_date' => '2017-09-30',
            'frequency' => 'monthly'
        ]);

        $income3 = $this->createIncome($user, [
            'amount' => 900.00,
            'start_date' => '2017-09-15',
            'frequency' => 'monthly'
        ]);

        $monthlyIncome = $user->getIncomeAmountForMonth();
        $this->assertEquals(4, $user->getIncomeDatesForMonth()->count());

        $this->assertEquals(6200.0000, $monthlyIncome);

        Carbon::setTestNow();
    }

    /** @test */
    public function can_get_income_dates_for_month()
    {
        Carbon::setTestNow('2017-10-01');
        $user = $this->createUser();
        $income1 = $this->createIncome($user, [
            'amount' => 2200.00,
            'start_date' => '2017-10-04',
            'frequency' => 'biweekly',
        ]);
        $income2 = $this->createIncome($user, [
            'amount' => 900.00,
            'start_date' => '2017-09-30',
            'frequency' => 'monthly'
        ]);

        $income3 = $this->createIncome($user, [
            'amount' => 900.00,
            'start_date' => '2017-09-15',
            'frequency' => 'monthly'
        ]);

        $incomeDates = $user->getIncomeDatesForMonth()->map->format('Y-m-d');
        $this->assertEquals(4, $incomeDates->count());

        collect([
            '2017-10-04',
            '2017-10-15',
            '2017-10-18',
            '2017-10-30',
        ])->each(function ($date) use ($incomeDates) {
            $this->assertTrue($incomeDates->contains($date), $date);
        });

        Carbon::setTestNow();
    }
}
