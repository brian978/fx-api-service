<?php

namespace App\Http\Controllers\Api;

use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ConvertorController extends Controller
{
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
