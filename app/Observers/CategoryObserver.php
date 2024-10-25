<?php

namespace App\Observers;

use App\Models\Category;
use Ramsey\Uuid\Uuid;

class CategoryObserver
{
    public function creating(Category $category): void
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Category::where('uuid', $uuid)->exists());
        if (! $category->uuid) {
            $category->uuid = $uuid;
        }
    }
}
