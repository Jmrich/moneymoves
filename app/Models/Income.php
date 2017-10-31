<?php

namespace App\Models;

use App\Factories\IncomeDateFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
}
