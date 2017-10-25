<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryGroup extends Model
{
    protected $guarded = ['id'];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function categoriesTotal()
    {
        return $this->categories->sum('amount');
    }
}
