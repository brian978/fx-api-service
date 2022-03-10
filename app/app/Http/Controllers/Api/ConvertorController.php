<?php

namespace App\Http\Controllers\Api;

use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ConvertorController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/convert/{base}/to/{quote}",
     *      summary="Submit conversion request",
     *      operationId="convert",
     *      tags={"exchange"},
     *      @OA\PathParameter (name="base", description="Currency to convert FROM", example="EUR"),
     *      @OA\PathParameter (name="quote", description="Currency to convert TO", example="RON"),
     *      @OA\Parameter (in="query", name="date", example="2022-01-03"),
     *      @OA\RequestBody (
     *           required=true,
     *           description="Conversion amount is required",
     *           @OA\JsonContent (
     *                required={"value"},
     *                @OA\Property (property="value", type="float", format="number", example="10"),
     *           ),
     *      ),
     *      @OA\Response (
     *           response=200,
     *           description="Success",
     *           @OA\JsonContent (
     *                @OA\Property (property="result", type="float"),
     *           )
     *      )
     * )
     */
    public function convert(Request $request, Currency $base, Currency $quote): JsonResponse
    {
        $date = $request->query('date', date('Y-m-d', time()));
        $value = $request->post('value');

        $dateObj = new \DateTime($date);
        $dateObj->setTime(0, 0);

        if ($quote->name !== Currency::BRIDGE_CURRENCY) {
            $result = $base->convertTo($quote, $value, $dateObj);
        } else {
            $result = $base->convert($value, $dateObj);
        }

        return response()->json(['result' => $result]);
    }
}
