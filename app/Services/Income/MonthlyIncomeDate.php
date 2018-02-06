<?php

namespace App\Services\Income;

use App\Contracts\IncomeDateInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class MonthlyIncomeDate implements IncomeDateInterface
{
    private const FEBRUARY = 2;

    public function getNextIncomeDate(Carbon $start): Carbon
    {
        $now = now();
        $day = $start->day;
        $nextIncomeDate = $now->day($this->getDayOfMonth($now, $day));

        if ($nextIncomeDate->isPast()) {
            $nextIncomeDate->startOfMonth()
                ->addMonth()
                ->day($this->getDayOfMonth($nextIncomeDate->copy(), $day));
        }

        return $nextIncomeDate;
    }

    public function getIncomeDateRange(Carbon $start): Collection
    {
        return $this->getMonths($start);
    }

    private function getMonths(Carbon $start)
    {
        $dayOfMonth = $start->day;
        $months = new Collection();
        $numberOfMonths = $start->diffInMonths(now()->addMonth(3));
        Collection::times($numberOfMonths, function ($number) use ($start, $months, $dayOfMonth) {
            $months->push($start->copy());

            $startOfNextMonth = $start->startOfMonth()->addMonth();
            $day = $this->getDayOfMonth($startOfNextMonth, $dayOfMonth);

            $startOfNextMonth->day($day);
        });

        return $months;
    }

    private function getDayOfMonth(Carbon $date, $day)
    {
        if ($date->month == self::FEBRUARY && $day > 28) {
            return $this->getDateForFebruary($date);
        }

        if ($this->is30DayMonth($date) && $day >= 30) {
            return 30;
        }

        return $day;
    }

    private function is30DayMonth(Carbon $date): bool
    {
        return $date->daysInMonth == 30;
    }

    private function getDateForFebruary(Carbon $date): int
    {
        return $date->isLeapYear() ? 29 : 28;
    }
}