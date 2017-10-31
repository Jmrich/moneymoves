<?php

namespace App\Contracts;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface IncomeDateInterface
{
    public function getNextIncomeDate(Carbon $start): Carbon;

    public function getIncomeDateRange(Carbon $start): Collection;
}