<?php

namespace App\Http\Controllers\Api;

use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class CurrenciesController extends Controller
{
    public function list(): JsonResponse
    {
        $currencies = Currency::with('rates')->get();

        return response()->json($currencies->toArray());
    }
}
