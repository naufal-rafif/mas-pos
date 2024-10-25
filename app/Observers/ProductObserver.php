<?php

namespace App\Observers;

use App\Models\Product;
use Ramsey\Uuid\Uuid;

class ProductObserver
{
    public function creating(Product $product): void
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Product::where('uuid', $uuid)->exists());
        if (! $product->uuid) {
            $product->uuid = $uuid;
        }
    }
}
