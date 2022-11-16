<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            ['name' => 'Meat','category' => 'Meat'],
            ['name' => 'Potato','category' => 'Vegetable'],
            ['name' => 'Garlic','category' => 'Vegetable'],
            ['name' => 'Onion','category' => 'Vegetable'],
            ['name' => 'Carrot','category' => 'Vegetable'],
            ['name' => 'Sugar','category' => 'Seasoning'],
            ['name' => 'Salt','category' => 'Seasoning'],
            ['name' => 'Virgin blood','category' => 'Seasoning'],
            ['name' => 'Pepper','category' => 'Seasoning'],
            ['name' => 'Tomato','category' => 'Vegetable'],
            ['name' => 'Wine','category' => 'Seasoning'],
        ])->each(function ($i) {
            Ingredient::create($i);
        });
    }
}
