<?php

namespace Tests\Unit\Income;

use App\Services\Income\WeeklyIncomeDate;
use Carbon\Carbon;
use Tests\TestCase;

class WeeklyIncomeTest extends TestCase
{
    /** @test */
    public function can_get_date_range()
    {
        $dates = (new WeeklyIncomeDate)->getIncomeDateRange(Carbon::parse('2017-10-04'));
        $dates->transform(function (Carbon $date) {
            return $date->format('Y-m-d');
        });

        collect([
            '2017-10-11',
            '2017-10-18',
            '2017-10-25',
            '2017-11-01',
        ])->each(function ($date) use ($dates) {
            $this->assertTrue($dates->contains($date));
        });
    }

    /** @test */
    public function can_get_next_income_date()
    {
        Carbon::setTestNow('2017-10-29');
        $date = (new WeeklyIncomeDate)->getNextIncomeDate(Carbon::parse('2017-10-04'));
        $this->assertEquals('2017-11-01', $date->format('Y-m-d'));
        Carbon::setTestNow();
    }
}
