<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = collect(['CPU', 'GPU', 'RAM', 'Motherboard', 'Storage', 'Monitor', 'Peripherals'])
        ->map(fn($name) => Category::create([
            'name' => $name, 
            'slug' => Str::slug($name)
        ]));

        $brands = collect(['Intel', 'AMD', 'NVIDIA', 'ASUS', 'MSI', 'Gigabyte', 'Corsair', 'Samsung'])
        ->map(fn($name) => Brand::create([
            'name' => $name, 
            'slug' => Str::slug($name)
        ]));

        Product::factory()
            ->count(400)
            ->create(function () use ($categories, $brands) {
                return [
                    'category_id' => $categories->random()->id,
                    'brand_id'    => $brands->random()->id,
                ];
            });
    }
}
