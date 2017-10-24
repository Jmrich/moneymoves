<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $guarded = ['id', 'user_id'];

    public function categoryGroups()
    {
        return $this->hasMany(CategoryGroup::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
