<?php

namespace Tests\Feature\Models;

use App\Models\Bill;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BillModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_get_bill_date()
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

        dd($bill->incomeSources());

//        dd($user->getIncomeSourcesForMonth());

        $dates = $user->getIncomeSourcesForMonth()
            ->filter(function (Carbon $date) use ($bill) {
                return $date->lte($bill->due_date);
            });

        dd($dates);
    }
}
