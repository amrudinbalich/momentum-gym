<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Realistic hardware naming dictionaries for the faker setup
        $prefixes = ['Ultra', 'Pro', 'Gaming X', 'Elite', 'Vanguard', 'Strix', 'TUF'];
        $series = ['RTX 5080', 'Ryzen 9 9950X', 'Z890 Wi-Fi', 'DDR5 32GB', 'NVMe 2TB', '4K 144Hz'];

        $name = $this->faker->randomElement($prefixes) . ' ' . $this->faker->randomElement($series) . ' ' . $this->faker->word();

        return [
            'name'        => ucwords($name),
            'description' => $this->faker->paragraphs(2, true),
            'price'       => $this->faker->randomFloat(2, 49, 1999), // Prices between $49.00 and $1999.00
            'quantity'    => $this->faker->numberBetween(0, 150),
            
            // Deliberately left to be overridden by the Seeder for relational integrity
            'category_id' => Category::factory(), 
            'brand_id'    => Brand::factory(),

            'sku'         => strtoupper(Str::random(3)) . '-' . $this->faker->unique()->numberBetween(100000, 999999),
            
            'specs'       => [
                'warranty' => $this->faker->randomElement(['1 Year', '2 Years', '3 Years']),
                'color'    => $this->faker->randomElement(['Black', 'White', 'RGB Edition']),
                'weight'   => $this->faker->randomFloat(1, 0.5, 5.0) . ' kg',
            ],
            'is_active'   => $this->faker->boolean(95), // 95% of products are live
        ];
    }
}
