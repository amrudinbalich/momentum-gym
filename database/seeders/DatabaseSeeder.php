<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {        
        // admin
        User::factory()->create([
            'name' => 'Amrudin',
            'email' => 'amrudin@admin.com',
            'password' => Hash::make('AdminRuLes.')
        ]);

        // 'normal' users
        User::factory(10)->create();

        $this->call([
            // BrandSeeder::class,
            // CategorySeeder::class,
            ProductSeeder::class
        ]);
    }
}
