<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecipesApiController extends Controller
{
    public function index()
    {
        return new RecipeResource(Recipe::with(['ingredients'])->get());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search(Request $request)
    {
        $recipes = Recipe::all();

        if ($request->search) {
            $recipes = Recipe::where('name', "like", "%{$request->search}%")
                ->orWhere('category', "like", "%{$request->search}%")
                ->orWhere('procedure', "like", "%{$request->search}%")
                ->get();
        } elseif ($request->ingredient_id) {
            $recipes = Recipe::where('ingredient_id', $request->ingredient_id)->get();
        }
        return RecipeResource::collection($recipes);
    }

    public function store(StoreRecipeRequest $request)
    {
        $recipe = Recipe::create($request->all());
        $recipe->ingredients()->sync($request->input('ingredients', []));

        return (new RecipeResource($recipe))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Recipe $recipe)
    {
        return new RecipeResource($recipe->load(['ingredients']));
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $recipe->update($request->all());
        $recipe->ingredients()->sync($request->input('ingredients', []));

        return (new RecipeResource($recipe))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
