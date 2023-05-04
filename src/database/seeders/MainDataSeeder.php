<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;

class MainDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topLevelCategorys = Category::factory()->count(4)->create();
        foreach ($topLevelCategorys as $category) {
            $secondLevelcategorys = Category::factory()->count(random_int(1, 4))->create(['parent_id' => $category]);
        }
        foreach ($secondLevelcategorys as $category) {
            $thirdLevelcategorys = Category::factory()->count(random_int(1, 4))->create(['parent_id' => $category]);
        }
        for ($i = 1; $i <= 30; $i++) {
            Item::factory()->create(['category_id' => Category::inRandomOrder()->select('id')->first()]);
        }
        Item::factory()->count(3)->create(['category_id' => Category::all()->random()->id]);
    }

}
