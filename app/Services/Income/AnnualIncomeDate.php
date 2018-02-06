<?php

namespace App\Services\Income;

use App\Contracts\IncomeDateInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AnnualIncomeDate implements IncomeDateInterface
{
    public function getNextIncomeDate(Carbon $start): Carbon
    {
        $now = now();

        $month = $start->month;
        $day = $start->day;

        $now->startOfMonth()->month($month);
        $dayOfMonth = $this->getDayOfMonth($now, $day);

        $nextIncomeDate = $now->day($dayOfMonth);

        if ($nextIncomeDate->isPast()) {
            $nextIncomeDate->startOfMonth()
                ->addYear()
                ->day($this->getDayOfMonth($nextIncomeDate->copy(), $day));
        }

        return $nextIncomeDate;
    }

    public function getIncomeDateRange(Carbon $start): Collection
    {
        return $this->getYears($start);
    }

    private function getYears(Carbon $start): Collection
    {
        $dayOfMonth = $start->day;
        $years = new Collection();
        $numberOfYears = $start->diffInYears(now()->addYear(3));
        Collection::times($numberOfYears, function ($number) use ($start, $years, $dayOfMonth) {
            $years->push($start->copy());

            $nextYear = $start->startOfMonth()->addYear();
            $day = $this->getDayOfMonth($nextYear, $dayOfMonth);

            $nextYear->day($day);
        });

        return $years;
    }

    private function getDayOfMonth(Carbon $date, $day)
    {
        if ($date->month == 2 && $day > 28) {
            return $this->getDateForFebruary($date);
        }

        return $day;
    }

    private function getDateForFebruary(Carbon $date): int
    {
        return $date->isLeapYear() ? 29 : 28;
    }
}