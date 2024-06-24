<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Resources\CouponResources\CouponResource;
use App\Models\Coupon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponController extends ApiController
{
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse     
     */
    public function show(Request $request): JsonResponse
    {
        $request->validate([
            "coupon_code" => ['required', 'string'],
        ]);
        $coupon = Coupon::where('code', $request->coupon_code)->active()->firstOrFail();
        return $this->jsonResponse(["data" => new CouponResource($coupon)]);
    }
}
