<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Bill extends Model
{
    protected $guarded = ['id'];

    protected $dates = ['due_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function incomeSources(): Collection
    {
        /** @var User $user */
        $user = $this->user;

        return $user->incomes->filter(function (Income $income) {
            return $income->dateOverlapsWithIncomeDate($this->due_date);
        });
    }
}
