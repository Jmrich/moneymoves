<?php

namespace Tests\Unit\Income;

use App\Services\Income\AnnualIncomeDate;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnnualIncomeTest extends TestCase
{
    /** @test */
    public function can_get_date_range()
    {
        $dates = (new AnnualIncomeDate())->getIncomeDateRange(Carbon::parse('2016-02-15'));
        $dates->transform(function (Carbon $date) {
            return $date->format('Y-m-d');
        });

        collect([
            '2017-02-15',
            '2018-02-15',
        ])->each(function ($date) use ($dates) {
            $this->assertTrue($dates->contains($date));
        });
    }

    /** @test */
    public function can_get_date_range_for_february()
    {
        $dates = (new AnnualIncomeDate())->getIncomeDateRange(Carbon::parse('2016-02-29'));
        $dates->transform(function (Carbon $date) {
            return $date->format('Y-m-d');
        });

        collect([
            '2017-02-28',
            '2018-02-28',
        ])->each(function ($date) use ($dates) {
            $this->assertTrue($dates->contains($date));
        });
    }

    /** @test */
    public function can_get_next_income_date()
    {
        Carbon::setTestNow('2017-10-29');
        $date = (new AnnualIncomeDate)->getNextIncomeDate(Carbon::parse('2016-02-29'));
        $this->assertEquals('2018-02-28', $date->format('Y-m-d'));
        Carbon::setTestNow();
    }
}
