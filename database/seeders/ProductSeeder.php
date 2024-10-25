<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Pecel Pororo',
                'price' => 15000,
                'qty' => 1000,
                'description' => 'Pecel pororo merupakan pecel khas timur barat',
                'uuid' => '473886a6-4e1a-4539-96dc-6c37ac9094af',
                'category_id' => Category::where('name', 'Makanan')->first()->id,
                'image' => 'pecel.jpg'
            ],
            [
                'name' => 'Kolak Tahu',
                'price' => 5000,
                'qty' => 100,
                'description' => 'Kolak Tahu merupakan pecel khas timur barat',
                'uuid' => 'ac5e12e7-2fb8-433f-a128-be9f47cbe27d',
                'category_id' => Category::where('name', 'Minuman')->first()->id,
                'image' => 'kolak.webp'
            ],
        ];

        foreach ($products as $product) {
            // Copy image from public path to storage/app/product
            $imagePath = public_path('images/product/' . $product['image']);
            $storagePath = 'product/' . $product['image'];
            if (File::exists($imagePath)) {
                Storage::disk('public')->put($storagePath, File::get($imagePath));
            }

            Product::createOrFirst([
                'uuid' => $product['uuid']
            ],[
                'name' => $product['name'],
                'price' => $product['price'],
                'qty' => $product['qty'],
                'description' => $product['description'],
                'category_id' => $product['category_id'],
                'image' => $storagePath, // Store the path to the image
            ]);
        }
    }
}

