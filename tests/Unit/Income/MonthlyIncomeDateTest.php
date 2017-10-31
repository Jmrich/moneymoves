<?php

namespace Tests\Unit\Income;

use App\Services\Income\MonthlyIncomeDate;
use Carbon\Carbon;
use Tests\TestCase;

class MonthlyIncomeDateTest extends TestCase
{
    /** @test */
    public function can_get_date_range_for_year_with_correct_dates()
    {
        $dates = (new MonthlyIncomeDate)->getIncomeDateRange(Carbon::parse('2016-12-31'));
        $dates->transform(function (Carbon $date) {
            return $date->format('Y-m-d');
        });

        $specialDates = [
            '2017-02-28',
            '2017-04-30',
            '2017-06-30',
            '2017-09-30',
            '2017-11-30',
        ];

        collect($specialDates)->each(function ($date) use ($dates) {
            $this->assertTrue($dates->contains($date), $date);
        });
    }

    /** @test */
    public function can_get_date_range_for_leap_year()
    {
        $dates = (new MonthlyIncomeDate)->getIncomeDateRange(Carbon::parse('2015-12-31'));
        $dates->transform(function (Carbon $date) {
            return $date->format('Y-m-d');
        });

        $specialDates = [
            '2016-02-29',
            '2016-04-30',
            '2016-06-30',
            '2016-09-30',
            '2016-11-30',
        ];

        collect($specialDates)->each(function ($date) use ($dates) {
            $this->assertTrue($dates->contains($date), $date);
        });
    }

    /** @test */
    public function can_get_next_income_date()
    {
        Carbon::setTestNow('2017-10-29');
        $date = (new MonthlyIncomeDate)->getNextIncomeDate(Carbon::parse('2016-12-28'));
        $this->assertEquals('2017-11-28', $date->format('Y-m-d'));
        Carbon::setTestNow();
    }
}
