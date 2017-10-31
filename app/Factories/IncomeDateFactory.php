<?php

namespace App\Factories;

use App\Contracts\IncomeDateInterface;
use App\Services\Income\AnnualIncomeDate;
use App\Services\Income\BiWeeklyIncomeDate;
use App\Services\Income\MonthlyIncomeDate;
use App\Services\Income\WeeklyIncomeDate;

class IncomeDateFactory
{
    public static function make(string $frequency): IncomeDateInterface
    {
        switch ($frequency) {
            case 'weekly':
                return new WeeklyIncomeDate;
            case 'biweekly':
                return new BiWeeklyIncomeDate;
            case 'monthly':
                return new MonthlyIncomeDate;
            case 'annually':
                return new AnnualIncomeDate;
            default:
                throw new \InvalidArgumentException('Invalid frequency: '.$frequency);
        }
    }
}