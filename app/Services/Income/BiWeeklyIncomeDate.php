<?php

namespace App\Services\Income;

use App\Contracts\IncomeDateInterface;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use Illuminate\Support\Collection;

class BiWeeklyIncomeDate implements IncomeDateInterface
{
    public function getNextIncomeDate(Carbon $start): Carbon
    {
        $dateRange = $this->getIncomeDateRange($start);

        $now = now();

        return $dateRange->first(function (Carbon $date) use ($now) {
            return $date->greaterThan($now);
        });
    }

    public function getIncomeDateRange(Carbon $start): Collection
    {
        $dateRange = $this->getDateInterval($start, now()->addMonth());

        return collect($dateRange);
    }

    private function getDateInterval(Carbon $start, Carbon $end): DatePeriod
    {
        $interval = new DateInterval('P2W');
        return new DatePeriod($start, $interval, $end);
    }
}