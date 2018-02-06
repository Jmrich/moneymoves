<?php

namespace App\Models;

use App\Factories\IncomeDateFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Income extends Model
{
    public const WEEKLY = 'weekly';
    public const BIWEEKLY = 'biweekly';
    public const MONTHLY = 'monthly';
    public const ANNUALLY = 'annually';

    public const PAY_PERIODS = [
        self::WEEKLY,
        self::BIWEEKLY,
        self::MONTHLY,
        self::ANNUALLY,
    ];

    protected $guarded = ['id'];

    protected $dates = [
        'start_date',
    ];

    public function getNextIncomeDate(): Carbon
    {
        return IncomeDateFactory::make($this->frequency)
            ->getNextIncomeDate($this->start_date);
    }

    public function getIncomeForMonth()
    {
        $incomeCount = $this->getIncomeDatesForMonth()->count();

        return $this->amount * $incomeCount;
    }

    public function getIncomeDatesForMonth(): Collection
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        return IncomeDateFactory::make($this->frequency)
            ->getIncomeDateRange($this->start_date)
            ->filter(function (Carbon $date) use ($startOfMonth, $endOfMonth) {
                return $date->gte($startOfMonth) && $date->lte($endOfMonth);
            });
    }

    public function dateOverlapsWithIncomeDate(Carbon $dueDate): bool
    {
        return $this->getIncomeDatesForMonth()
            ->filter(function (Carbon $date) use ($dueDate) {
                return $date->lte($dueDate);
            })->isNotEmpty();
    }
}
