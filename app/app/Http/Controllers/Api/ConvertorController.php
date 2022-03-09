<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Conversion;
use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class ConvertorController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/convert/{base}/to/{quote}",
     *      summary="Submit conversion request",
     *      operationId="convert",
     *      tags={"convertor"},
     *      @OA\PathParameter (name="base", description="Currency to convert FROM", example="EUR"),
     *      @OA\PathParameter (name="quote", description="Currency to convert TO", example="RON"),
     *      @OA\Parameter (in="query", name="date", example="2022-01-03"),
     *      @OA\RequestBody (
     *           required=true,
     *           description="Conversion amount is required",
     *           @OA\JsonContent (
     *                required={"value"},
     *                @OA\Property (property="amount", type="float", format="number", example="10"),
     *           ),
     *      ),
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
    public function convert(Request $request, Currency $base, Currency $quote): JsonResponse
    {
        $isInvalid = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'date' => 'date'
        ])->fails();

        if ($isInvalid) {
            return response()->json(['error' => 'Invalid request'], Response::HTTP_BAD_REQUEST);
        }

        $date = $request->query('date', date('Y-m-d', time()));
        $amount = (float)$request->post('amount');

        $conversion = new Conversion();
        $conversion->make($base, $quote, $amount, new \DateTime($date));

        return response()->json(['date' => $conversion->date->format('Y-m-d'), 'value' => $conversion->value]);
    }
}
