<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IngredientsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ingredient-list|ingredient-view|ingredient-create|ingredient-update|ingredient-delete', ['only' => ['index','show']]);
        $this->middleware('permission:ingredient-create', ['only' => ['create','store']]);
        $this->middleware('permission:ingredient-update', ['only' => ['edit','update']]);
        $this->middleware('permission:ingredient-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $ingredients = Ingredient::all();

        return view('ingredients.index', compact('ingredients'));
    }

    public function create()
    {
        return view('ingredients.create');
    }

    public function store(StoreIngredientRequest $request)
    {
        $ingredient = Ingredient::create($request->all());

        return redirect()->route('ingredients.index');
    }

    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.edit', compact('ingredient'));
    }

    public function update(UpdateIngredientRequest $request, Ingredient $ingredient)
    {
        $ingredient->update($request->all());

        return redirect()->route('ingredients.index');
    }

    public function show(Ingredient $ingredient)
    {
        return view('ingredients.show', compact('ingredient'));
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();

        return back();
    }
}
