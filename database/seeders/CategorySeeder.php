<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['name' => 'CPU', 'slug' => 'cpu'],
            ['name' => 'GPU', 'slug' => 'gpu'],
            ['name' => 'RAM', 'slug' => 'ram'],
            ['name' => 'Motherboard', 'slug' => 'motherboard'],
            ['name' => 'Storage', 'slug' => 'storage'],
            ['name' => 'Monitor', 'slug' => 'monitor'],
            ['name' => 'Peripherals', 'slug' => 'peripherals'],
        ]);
    }
}
