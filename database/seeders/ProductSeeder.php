<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Product::create([
            'name' => 'Sabun Herbal The Nature',
            'description' => 'Sabun herbal alami untuk kulit sensitif.',
            'price' => 25000,
            'stock' => 10,
            'image_url' => null,
        ]);
    }
}
