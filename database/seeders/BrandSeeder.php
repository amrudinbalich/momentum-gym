<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::insert([
            ['name' => 'Intel', 'slug' => 'intel'],
            ['name' => 'AMD', 'slug' => 'amd'],
            ['name' => 'NVIDIA', 'slug' => 'nvidia'],
            ['name' => 'ASUS', 'slug' => 'asus'],
            ['name' => 'MSI', 'slug' => 'msi'],
            ['name' => 'Gigabyte', 'slug' => 'gigabyte'],
            ['name' => 'Corsair', 'slug' => 'corsair'],
            ['name' => 'Samsung', 'slug' => 'samsung'],
        ]);
    }
}
