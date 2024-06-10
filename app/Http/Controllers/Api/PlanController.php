<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use Core\Plan\Application\DTO\InputPlansDTO;
use Core\Plan\Application\UseCase\GetPlansUseCase;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetPlansUseCase $useCase, Request $request)
    {
        $plans = $useCase->execute(new InputPlansDTO(
            filter: $request->input('filter', ''),
            orderBy: $request->input('order_by', 'DESC'),
            page: $request->input('page', 1),
            totalPerPage: $request->input('per_page', 15),
        ));

        return PlanResource::collection(collect($plans->items))->additional([
            'meta' => [
                'total' => $plans->total,
                'last_page' => $plans->last_page,
                'first_page' => $plans->first_page,
                'next_page' => $plans->next_page,
                'previous_page' => $plans->previous_page,
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
