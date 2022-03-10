<?php

namespace App\Http\Controllers\Api;

use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class CurrenciesController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/currencies",
     *      summary="List of supported currencies",
     *      operationId="currencies",
     *      tags={"exchange"},
     *      @OA\Response (
     *           response=200,
     *           description="Success",
     *           @OA\JsonContent (
     *                type="array",
     *                @OA\Items (
     *                    @OA\Property (property="name", type="string", example="RON"),
     *                )
     *           )
     *      )
     * )
     */
    public function currencies(): JsonResponse
    {
        return response()->json(Currency::all()->toArray());
    }
}
