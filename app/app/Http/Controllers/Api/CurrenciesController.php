<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class CurrenciesController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/currencies",
     *      summary="List of supported currencies",
     *      operationId="currencies",
     *      tags={"currencies"},
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

    /**
     * @OA\Get(
     *      path="/api/currencies/{currency}/rate",
     *      summary="Retrieve the rate again RON at a given date",
     *      operationId="rate",
     *      tags={"currencies"},
     *      @OA\PathParameter (name="currency", description="Currency for which to see the RON value", example="EUR"),
     *      @OA\Parameter (in="query", name="date", example="2022-01-03", required=true),
     *      @OA\Response (
     *           response=200,
     *           description="Success",
     *           @OA\JsonContent (
     *                @OA\Property (property="date", type="date", example="2022-01-03"),
     *                @OA\Property (property="value", type="float", example="4.94"),
     *           )
     *      ),
     *      @OA\Response (
     *            response=400,
     *            description="Bad request",
     *            @OA\JsonContent (
     *                 @OA\Property (property="error", type="string", example="Invalid request")
     *            )
     *      )
     * )
     * @throws \Exception
     */
    public function rate(Request $request, Currency $currency): JsonResponse
    {
        $isInvalid = Validator::make($request->all(), [
            'date' => 'required|date'
        ])->fails();

        if ($isInvalid) {
            return response()->json(['error' => 'Invalid request'], Response::HTTP_BAD_REQUEST);
        }

        $date = $request->query('date');

        $rate = $currency->rate(new \DateTime($date));

        return response()->json(['date' => $rate->date()->format('Y-m-d'), 'value' => $rate->value]);
    }
}
