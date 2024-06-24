<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Resources\PaymentMethodResources\PaymentMethodResourceCollection;
use App\Models\PaymentMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class PaymentMethodController extends ApiController
{
    /**
     * Display a listing of the active resource.
     *
     * @return \Illuminate\Http\JsonResponse     
     */
    public function index(): JsonResponse
    {
        return $this->jsonResponse(["data" => new PaymentMethodResourceCollection(
            Cache::remember(PaymentMethod::CACHE_KEY, PaymentMethod::CACHE_TTL, function () {
                return PaymentMethod::active()->OrderBy('name', 'ASC')->get();
            })
        )]);
    }
}
