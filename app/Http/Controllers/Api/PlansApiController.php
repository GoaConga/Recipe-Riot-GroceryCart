<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlansApiController extends Controller
{
    public function index()
    {
        return new PlanResource(Plan::with(['recipes'])->get());
    }

    public function store(StorePlanRequest $request)
    {
        $plan = Plan::create($request->all());
        $plan->recipes()->sync($request->input('recipes', []));

        return (new PlanResource($plan))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Plan $plan)
    {
        return new PlanResource($plan->load(['recipes']));
    }

    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        $plan->update($request->all());
        $plan->recipes()->sync($request->input('recipes', []));

        return (new PlanResource($plan))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(int $id)
    {
        $plan = Plan::query()->where('id', $id)->first();

        $destroyedPlan = $plan;
        $response = response()->json(
            [
                'status' => false,
                'message' => "Unable to delete: Plan Not Found",
                'authors' => null
            ],
            404  # Not Found
        );

        if (!is_null($plan) && $plan->count() > 0) {
            $plan->delete();

            $response = response()->json(
                [
                    'status' => true,
                    'message' => "Plan deleted.",
                    'authors' => $destroyedPlan
                ],
                200  # Ok
            );
        }

        return $response;
    }
}
