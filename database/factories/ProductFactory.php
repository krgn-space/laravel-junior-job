<?php declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        $statuses = ProductStatus::cases();

        $status = fake()->randomElement($statuses);

        return [
            'name' => 'Product-' . fake()->name(),
            'article' => 'article_' . fake()->unique()->numberBetween(100000, 999999),
            'status' => $status->value,
            'data' => json_encode([
                'color' => fake()->randomElement(['red', 'green', 'blue'])
            ])
        ];
    }
}
