<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Makanan', 'description' => 'Berbagai jenis makanan Nusantara', 'uuid' => '28a028ae-699c-4c33-bfd8-1e6d412675fb'],
            ['name' => 'Minuman', 'description' => 'Berbagai jenis minuman Nusantara', 'uuid' => '28a028ae-699c-4c33-bfd8-1e6d412789wn'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate([
                'uuid' => $category['uuid']
            ], [
                'name' => $category['name'],
                'description' => $category['description'],
            ]);
        }
    }
}
