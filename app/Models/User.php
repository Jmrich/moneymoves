<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function getNextIncomeDate(): Carbon
    {
        $now = now();
        /** @var Collection $incomes */
        $incomes = $this->incomes;

        return $incomes->map(function (Income $income) {
            return $income->getNextIncomeDate();
        })->sortByDesc(function (Carbon $date) use ($now) {
            return $now->diffInDays($date);
        })->last();
    }

    public function getNextIncomeAmount()
    {
        $now = now();
        $nextFriday = $now->copy()->next(Carbon::FRIDAY);
        $incomes = $this->incomes;

        return $incomes->filter(function (Income $income) use ($now, $nextFriday) {
            $nextIncomeDate = $income->getNextIncomeDate();
            return $nextIncomeDate->greaterThan($now) && $nextIncomeDate->lessThanOrEqualTo($nextFriday);
        })->sum('amount');
    }

    public function getIncomeAmountForMonth()
    {
        return $this->incomes->sum(function (Income $income) {
            return $income->getIncomeForMonth();
        });
    }

    public function getIncomeDatesForMonth(): Collection
    {
        return $this->getIncomeSourcesForMonth()
            ->map(function (Income $income) {
                return $income->getIncomeDatesForMonth();
            })->filter(function (Collection $dates) {
                return $dates->isNotEmpty();
            })->flatten()
            ->sort()
            ->values();
    }

    public function getIncomeSourcesForMonth(): Collection
    {
        return $this->incomes->filter(function (Income $income) {
            return $income
                ->getIncomeDatesForMonth()
                ->isNotEmpty();
        });
    }
}
