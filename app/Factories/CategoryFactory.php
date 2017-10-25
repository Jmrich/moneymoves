<?php

namespace App\Factories;

use App\Models\Category;
use App\Models\CategoryGroup;

class CategoryFactory
{
    public function create(CategoryGroup $categoryGroup, string $name): Category
    {
        return $categoryGroup->categories()->create([
            'name' => $name,
        ]);
    }
}