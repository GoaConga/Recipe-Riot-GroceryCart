<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Models\Plan;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlansController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:plan-list|plan-view|plan-create|plan-update|plan-delete', ['only' => ['index','show']]);
        $this->middleware('permission:plan-create', ['only' => ['create','store']]);
        $this->middleware('permission:plan-update', ['only' => ['edit','update']]);
        $this->middleware('permission:plan-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $plans = Plan::latest()->paginate(7);
        return view('plans.index',compact('plans'))
            ->with('i', (request()->input('page', 1) - 1) * 7);
    }

    public function create()
    {
        return view('plans.create', [
            'recipes' => Recipe::get(),
        ]);
    }

    public function store(StorePlanRequest $request)
    {
        $data = $request->validated();

        /** @var Plan $plan */
        $plan = Plan::create($data);

        $plan->recipes()->sync($this->mapRecipes($data['recipes']));

        return redirect()->route('plans.index');
    }

    public function edit(Plan $plan)
    {
        $plan->load('recipes');

        $recipes = Recipe::get()->map(function($recipe) use ($plan) {
            $recipe->value = data_get($plan->recipes->firstWhere('id', $recipe->id), 'pivot.type') ?? null;
            return $recipe;
        });

        return view('plans.edit', [
            'recipes' => $recipes,
            'plan' => $plan,
        ]);
    }

    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        $data = $request->validated();

        $plan->update($data);
        $plan->recipes()->sync($this->mapRecipes($data['recipes']));

        return redirect()->route('plans.index');
    }

    public function show(Plan $plan)
    {
        $plan->load('recipes');

        return view('plans.show', compact('plan'));
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();

        return back();
    }

    private function mapRecipes($recipes)
    {
        return collect($recipes)->map(function ($i) {
            return ['type' => $i];
        });
    }
}
