<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryGroup extends Model
{
    protected $guarded = ['id'];

    public const DEFAULT_CATEGORY_GROUPS = [
        'Family',
        'Savings',
        'Debt Payments',
        'Entertainment',
        'Home Entertainment',
        'Investment',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
