<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IngredientsApiController extends Controller
{
    public function index()
    {
        return new IngredientResource(Ingredient::all());
    }

    public function store(StoreIngredientRequest $request)
    {
        $ingredient = Ingredient::create($request->all());

        return (new IngredientResource($ingredient))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Ingredient $ingredient)
    {
        return new IngredientResource($ingredient);
    }

    public function update(UpdateIngredientRequest $request, Ingredient $ingredient)
    {
        $ingredient->update($request->all());

        return (new IngredientResource($ingredient))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
