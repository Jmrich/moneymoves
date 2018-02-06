<?php

namespace Tests\Feature\Models;

use App\Models\Bill;
use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class IncomeModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_get_next_annual_income_date()
    {
        $user = $this->createUser();

        /** @var Income $income */
        $income = factory(Income::class)->create([
            'user_id' => $user->id,
            'frequency' => 'annually',
            'start_date' => '2017-08-31',
        ]);

        $this->assertEquals('2018-08-31', $income->getNextIncomeDate()->format('Y-m-d'));
    }

    /** @test */
    public function can_get_income_for_month()
    {
        Carbon::setTestNow('2017-10-01');
        $user = $this->createUser();
        $income = $this->createIncome($user, [
            'amount' => 2200.00,
            'start_date' => '2017-10-04',
            'frequency' => 'biweekly',
        ]);

        $this->assertEquals(4400.0000, $income->getIncomeForMonth());
    }

    /** @test */
    public function can_get_income_model_when_bill_due_date_overlaps()
    {
        $user = $this->createUser();
        $income1 = $this->createIncome($user, [
            'amount' => 2200.00,
            'start_date' => '2017-10-18',
            'frequency' => 'biweekly',
        ]);

        /** @var Bill $bill */
        $bill = factory(Bill::class)->create([
            'user_id' => $user->id,
            'amount' => 100,
            'due_date' => '2017-11-04'
        ]);

        $temp = $income1->dateOverlapsWithIncomeDate($bill->due_date);
        dd($temp);
    }
}
