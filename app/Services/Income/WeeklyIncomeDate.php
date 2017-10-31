<?php

namespace App\Services\Income;

use App\Contracts\IncomeDateInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class WeeklyIncomeDate implements IncomeDateInterface
{
    public function getNextIncomeDate(Carbon $start): Carbon
    {
        $now = now();
        $dayOfWeek = $start->dayOfWeek;
        $nextIncomeDate = $now->next($dayOfWeek);

        return $nextIncomeDate;
    }

    public function getIncomeDateRange(Carbon $start): Collection
    {
        return $this->getWeeks($start, now()->addMonth(2));
    }

    private function getWeeks(Carbon $start, Carbon $end)
    {
        $weeks = new Collection;
        $numberOfWeeks = $start->diffInWeeks($end);

        Collection::times($numberOfWeeks, function ($number) use ($start, $weeks) {
            $weeks->push($start->copy());
            $start->addWeek();
        });

        if ($start->lessThan($end)) {
            $weeks->push($start);
        }

        return $weeks;
    }
}