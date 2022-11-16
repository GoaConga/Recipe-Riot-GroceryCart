<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Recipe;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $seedPlans = [
            [
                "week" => "Monday",
                "name" => "Meeting with Gold Metal company",
                "description" => "The meals will be divided into three in terms of using gold flakes as decoration tables.",
                "Date" => Carbon::parse('2000-01-01'),
                "recipes" => [
                    "GUINNESS-Bread-Version-2-2Recipe, Morning",
                    "Spanish-Potato-Omelette, Lunch",
                    "Kofta-Potato-Meatballs, Dinner",
                ],
            ],
            [
                "week" => "Tuesday",
                "name" => "Self serve food occasions",
                "description" => "This day will be a day for all the friends over here.",
                "Date" => Carbon::parse('2000-01-01'),
                "recipes" => [
                    "Cheesecake, Break",
                    "GUINNESS-Bread-Recipe, Dinner",
                    "GUINNESS-Chocolate-Truffles, Dessert",
                ],
            ],
            [
                "week" => "Wednesday",
                "name" => "Old food day",
                "description" => "Today will be a very boring day for the chatters.",
                "Date" => Carbon::parse('2000-01-01'),
                "recipes" => [
                    "Cheesecake, Break",
                    "Spanish-Potato-Omelette, Lunch",
                    "GUINNESS-Chocolate-Truffles, Dessert",
                ],
            ],
            [
                "week" => "Thursday",
                "name" => "Fun day with 4 meals provided",
                "description" => "Lots of customers and vistors booking today, so I will be treating myself with four meals for today.",
                "Date" => Carbon::parse('2000-01-01'),
                "recipes" => [
                    "Spanish-Potato-Omelette, Lunch",
                    "Kofta-Potato-Meatballs, Dinner",
                    "Black-Velvet-Cocktail, Dinner",
                ],
            ],
            [
                "week" => "Friday",
                "name" => "Gold Metal company's result review meeting day",
                "description" => "This day will be a day for all the staffs.",
                "Date" => Carbon::parse('2000-01-01'),
                "recipes" => [
                    "GUINNESS-Bread-Recipe, Dinner",
                    "Cheesecake, Break",
                    "GUINNESS-Chocolate-Truffles, Dessert",
                ],
            ],
            [
                "week" => "Saturday",
                "name" => "Cool collision food day",
                "description" => "Today will be a very boring day for the chatters.",
                "Date" => Carbon::parse('2000-01-01'),
                "recipes" => [
                    "Cheesecake, Break",
                    "Cheesecake, Break",
                    "Spanish-Potato-Omelette, Lunch",
                ],
            ],
            [
                "week" => "Sunday",
                "name" => "Sunday treats",
                "description" => "Today will be a very boring day for the regular lunches and chatters.",
                "Date" => Carbon::parse('2000-01-01'),
                "recipes" => [
                    "Cheesecake, Break",
                    "Spanish-Potato-Omelette, Lunch",
                    "GUINNESS-Chocolate-Truffles, Dessert",
                ],
            ],
            [
                "week" => "Monday",
                "name" => "Free for self day",
                "description" => "This day will be a day for all the friends over here.",
                "Date" => Carbon::parse('2000-01-01'),
                "recipes" => [
                    "GUINNESS-Bread-Recipe, Dinner",
                    "Cheesecake, Break",
                    "GUINNESS-Chocolate-Truffles, Dessert",
                ],
            ],
            [
                "week" => "Tuesday",
                "name" => "Self serve food occasions",
                "description" => "This day will be a day for all the friends over here.",
                "Date" => Carbon::parse('2000-01-01'),
                "recipes" => [
                    "Cheesecake, Break",
                    "GUINNESS-Bread-Recipe, Dinner",
                    "GUINNESS-Chocolate-Truffles, Dessert",
                ],
            ],
            [
                "week" => "Wednesday",
                "name" => "Old food day",
                "description" => "Today will be a very boring day for the chatters.",
                "Date" => Carbon::parse('2000-01-01'),
                "recipes" => [
                    "Cheesecake, Break",
                    "Spanish-Potato-Omelette, Lunch",
                    "GUINNESS-Chocolate-Truffles, Dessert",
                ],
            ],
            [
                "week" => "Thursday",
                "name" => "Fun day with 4 meals provided",
                "description" => "Lots of customers and vistors booking today, so I will be treating myself with four meals for today.",
                "Date" => Carbon::parse('2000-01-01'),
                "recipes" => [
                    "Spanish-Potato-Omelette, Lunch",
                    "Kofta-Potato-Meatballs, Dinner",
                    "Black-Velvet-Cocktail, Dinner",
                ],
            ],
            [
                "week" => "Friday",
                "name" => "Gold Metal company's result review meeting day",
                "description" => "This day will be a day for all the staffs.",
                "Date" => Carbon::parse('2000-01-01'),
                "recipes" => [
                    "GUINNESS-Bread-Recipe, Dinner",
                    "Cheesecake, Break",
                    "GUINNESS-Chocolate-Truffles, Dessert",
                ],
            ]
        ];
        $countItems = count($seedPlans);

        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $countItems);

        $this->command->getOutput()->writeln("<info>Seeding with {$countItems} Plans.");

        foreach ($seedPlans as $plan) {

            $recipes = $plan['recipes'];    // Get the list of authors for the book
            $recipe_list = [];  // create an empty list of authors

            // Go through the authors one by one
            foreach ($recipes as $recipe) {

                // Expand the author name (family name, given name) into Given and Family names
                $recipeName = null;
                $recipeCategory = $recipe;
                if ($comma = mb_strpos($recipe, ",")) {
                    $recipeName = trim(mb_substr($recipe, 0, $comma));
                    $recipeCategory = trim(mb_substr($recipe, $comma + 1, mb_strlen($recipe)));
                }

                // Check to see if we have the author in the table (yes => author, no => null)
                // if null then we create the new author
                $recipe = Recipe::whereName($recipeName)->whereCategory($recipeCategory)->first();
                if (is_null($recipe)) {
                    $newRecipe = [
                        "name" => $recipeName,
                        "category" => $recipeCategory,
                    ];
                    // The author wasn't found so we create them
                    $recipe = Recipe::create($newRecipe);
                }
                // add the existing, or new author's id to the author list
                $recipe_list[] = $recipe->id;
            }

            # Create book record
            $newPlan = [
                'week' => $plan['week'] ?? null,
                'name' => $plan['name'] ?? null,
                'description' => $plan['description'] ?? null,
                'date' => $plan['date'] ?? null,
            ];
            $thePlan = Plan::create($newPlan);

            # Link the authors to the book
            $thePlan->recipes()->attach($recipe_list);

            $progressBar->advance();
        }
        $progressBar->finish();
        $this->command->getOutput()->writeln("");

    }
}
