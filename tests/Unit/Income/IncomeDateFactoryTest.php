<?php

namespace Tests\Unit\Income;

use App\Factories\IncomeDateFactory;
use App\Services\Income\AnnualIncomeDate;
use App\Services\Income\BiWeeklyIncomeDate;
use App\Services\Income\MonthlyIncomeDate;
use App\Services\Income\WeeklyIncomeDate;
use Tests\TestCase;

class IncomeDateFactoryTest extends TestCase
{
    /** @test */
    public function can_make_instances()
    {
        $this->assertInstanceOf(WeeklyIncomeDate::class, IncomeDateFactory::make('weekly'));

        $this->assertInstanceOf(BiWeeklyIncomeDate::class, IncomeDateFactory::make('biweekly'));

        $this->assertInstanceOf(MonthlyIncomeDate::class, IncomeDateFactory::make('monthly'));

        $this->assertInstanceOf(AnnualIncomeDate::class, IncomeDateFactory::make('annually'));
    }

    /** @test */
    public function exception_thrown_for_incorrect_type()
    {
        $this->expectException(\InvalidArgumentException::class);

        IncomeDateFactory::make('unknown');
    }
}
