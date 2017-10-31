<?php

namespace Tests\Feature\Models;

use App\Models\Income;
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
}
