<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $seedRecipes = [
            [
                "name" => "Guinness-Bread-Recipe",
                "category" => "Dinner",
                "serve" => "One loaf",
                "fave" => 1,
                "rating" => 5,
                "procedure" => "Mix Butter with all dry ingredients until the dough develops the consistency of breadcrumbs, add the milk, black treacle and the GUINNESS draught.",
                "ingredients" => [
                    "Wholemeal-flour, Flour",
                    "plain-four, Flour",
                    "Oatmeal, Bread",
                    "Bread soda, Seasoning",
                    "Salt, Seasoning",
                    "Brown-Sugar, sweetening",
                    "Butter, Diary",
                    "Milk, Diary",
                    "Black-treacle, Diary",
                    "GUINNESS, Diary"
                ],
            ],
            [
                "name" => "Kofta-Potato-Meatballs",
                "category" => "Dinner",
                "serve" => "2",
                "fave" => 1,
                "rating" => 4,
                "procedure" => "Boil potatoes till cooked and mash. Mix together with potatoes the rest of the ingredients. Roll into small balls.",
                "ingredients" => [
                    "Potato, vegetable",
                    "Beef, Meat",
                    "Lamb, Meat",
                    "Onion, Vegetable",
                    "Coriander, vegetable",
                    "Butter, Diary",
                    "Vegetable-Oil, Diary"
                ],
            ],
            [
                "name" => "Spanish-Potato-Omelette",
                "category" => "Lunch",
                "serve" => "3",
                "fave" => 0,
                "rating" => 2,
                "procedure" => "Peel and slice potatoes thinly. In a hot oiled skillet add potatoes, onion, olives, herbs, garlic, salt and pepper.",
                "ingredients" => [
                    "Potato, vegetable",
                    "Onion, vegetable",
                    "Olive, Diary",
                    "Herb, Vegetable",
                    "Garlic, vegetable",
                    "Salt, Seasoning",
                    "Pepper, Seasoning",
                    "Virgin-olive, Diary",
                    "Egg, Protein",
                ],
            ],
            [
                "name" => "Black Velvet Cocktail",
                "category" => "Dinner",
                "serve" => "1",
                "fave" => 0,
                "rating" => 3,
                "procedure" => "Pour the Guinness Extra Stout into a clean/polished champagne flute. Top up the glass with the champagne, being careful to",
                "ingredients" => [
                    "Champagne, Wine",
                    "Stout, Ale",
                ],
            ],
            [
                "name" => "GUINNESS-Chocolate-Truffles",
                "category" => "Dessert",
                "serve" => "25",
                "fave" => 1,
                "rating" => 4,
                "procedure" => "Add the cream and GUINNESS to a saucepan and bring to the boil. Add the chocolate and grated orange zest. Mix together until the chocolate is fully melted.",
                "ingredients" => [
                    "chocolate, Sweet",
                    "Cream, Sweet",
                    "GUINNESS, Diary",
                    "Orange, Fruit",
                    "Cocoa, Fruit",
                    "Coconut, Fruit",
                ],
            ],
            [
                "name" => "Cheesecake",
                "category" => "Break",
                "serve" => "6",
                "fave" => 1,
                "rating" => 5,
                "procedure" => "Grease a 7- or 8-inch loose-bottomed cake-tin. Pre-heat the oven to 180 degree/350. F/Gas 4. Melt the butter in a saucepan and add the biscuits.",
                "ingredients" => [
                    "Base, Diary",
                    "Butter, Diary",
                    "Margarine, Diary",
                    "chocolate, Sweet",
                    "Biscuit, Diary",
                    "Cheese, Diary",
                    "Yoghurt, Diary",
                    "Egg, Protein",
                    "Cornflour, Diary",
                    "Sugar, Sweet",
                    "Topping, Sweet",
                    "Cream, Sweet",
                    "Pie, Sweet",
                    "Fruit, Fruit"
                ],
            ],
            [
                "name" => "GUINNESS-Bread-Version-2-2Recipe",
                "category" => "Morning",
                "serve" => "1",
                "fave" => 0,
                "rating" => 3,
                "procedure" => "Brown onions, garlic and meat. Sprinkle on curry powder. Add salt, sugar, vinegar, jam, carrots and mix well. Soak cread in milk, drain off meat mixture.",
                "ingredients" => [
                    "Beef, Meat",
                    "Onion, Vegetable",
                    "Carrot, Vegetable",
                    "Salt, Seasoning",
                    "Oil, Diary",
                    "Milk, Diary",
                    "Curry, Diary",
                    "Vingegar, Ale",
                    "Apricot, Wine",
                    "Sugar, Sweet",
                    "White-bread, Diary",
                    "Egg, Protein",
                    "Pepper, Seasoning",
                    "Ginger, Vegetable",
                    "Herb, Vegetable",
                    "Thyme, Vegetable",
                    "Parsley, Vegetable",
                ],
            ],
        ];
        $countItems = count($seedRecipes);

        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $countItems);

        $this->command->getOutput()->writeln("<info>Seeding with {$countItems} Recipes.");

        foreach ($seedRecipes as $recipe) {

            $ingredients = $recipe['ingredients'];    // Get the list of authors for the book
            $ingredient_list = [];  // create an empty list of authors

            // Go through the authors one by one
            foreach ($ingredients as $ingredient) {

                // Expand the author name (family name, given name) into Given and Family names
                $ingredientName = null;
                $ingredientCategory = $ingredient;
                if ($comma = mb_strpos($ingredient, ",")) {
                    $ingredientName = trim(mb_substr($ingredient, 0, $comma));
                    $ingredientCategory = trim(mb_substr($ingredient, $comma + 1, mb_strlen($ingredient)));
                }

                // Check to see if we have the author in the table (yes => author, no => null)
                // if null then we create the new author
                $ingredient = Ingredient::whereName($ingredientName)->whereCategory($ingredientCategory)->first();
                if (is_null($ingredient)) {
                    $newIngredient = [
                        "name" => $ingredientName,
                        "category" => $ingredientCategory,
                    ];
                    // The author wasn't found so we create them
                    $ingredient = Ingredient::create($newIngredient);
                }
                // add the existing, or new author's id to the author list
                $ingredient_list[] = $ingredient->id;
            }

            # Create book record
            $newRecipe = [
                'name' => $recipe['name'] ?? null,
                'category' => $recipe['category'] ?? null,
                'serve' => $recipe['serve'] ?? null,
                'fave' => $recipe['fave'] ?? null,
                'rating' => $recipe['rating'] ?? null,
                'procedure' => $recipe['procedure'] ?? null,
            ];
            $theRecipe = Recipe::create($newRecipe);

            # Link the authors to the book
            $theRecipe->ingredients()->attach($ingredient_list);

            $progressBar->advance();
        }
        $progressBar->finish();
        $this->command->getOutput()->writeln("");

    }
}
