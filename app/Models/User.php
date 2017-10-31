<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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
}
