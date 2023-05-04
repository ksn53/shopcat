<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
        return [
            'name' => $faker->productName,
            'category_id' => Category::factory(),
            'description' => $this->faker->sentences(4, true),
            'info' => $this->faker->paragraph(2),
            'slug' => $this->faker->lexify(),
            'price' => $this->faker->randomNumber(2),
            'weight' => $this->faker->randomNumber(2),
            'photo' => 'item.png',
        ];
    }
}
