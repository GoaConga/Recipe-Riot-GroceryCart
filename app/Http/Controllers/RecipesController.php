<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecipesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:recipe-list|recipe-view|recipe-create|recipe-update|recipe-delete', ['only' => ['index','show']]);
        $this->middleware('permission:recipe-create', ['only' => ['create','store']]);
        $this->middleware('permission:recipe-update', ['only' => ['edit','update']]);
        $this->middleware('permission:recipe-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $recipes = Recipe::all();
        if ($request->has('search')) {
            $recipes = Recipe::where('name', "like", "%{$request->search}%")
                ->orWhere('category', "like", "%{$request->search}%")
                ->orWhere('procedure', "like", "%{$request->search}%")
                ->get();
        }

        return view('recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('recipes.create', [
            'ingredients' => Ingredient::get(),
        ]);
    }

    public function store(StoreRecipeRequest $request)
    {
        $data = $request->validated();

        /** @var Recipe $recipe */
        $recipe = Recipe::create($data);

        $recipe->ingredients()->sync($this->mapIngredients($data['ingredients']));

        return redirect()->route('recipes.index');
    }

    public function edit(Recipe $recipe)
    {
        $recipe->load('ingredients');

        $ingredients = Ingredient::get()->map(function($ingredient) use ($recipe) {
            $ingredient->value = data_get($recipe->ingredients->firstWhere('id', $ingredient->id), 'pivot.amount') ?? null;
            return $ingredient;
        });

        return view('recipes.edit', [
            'ingredients' => $ingredients,
            'recipe' => $recipe,
        ]);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $data = $request->validated();

        $recipe->update($data);
        $recipe->ingredients()->sync($this->mapIngredients($data['ingredients']));

        return redirect()->route('recipes.index');
    }

    public function show(Recipe $recipe)
    {
        $recipe->load('ingredients');

        return view('recipes.show', compact('recipe'));
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return back();
    }

    private function mapIngredients($ingredients)
    {
        return collect($ingredients)->map(function ($i) {
            return ['amount' => $i];
        });
    }
}
