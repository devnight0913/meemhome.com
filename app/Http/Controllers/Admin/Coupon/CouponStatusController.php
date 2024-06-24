<?php

namespace App\Http\Controllers\Admin\Coupon;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CouponStatusController extends Controller
{

    /**
     * Update the specified resource status in storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Coupon $coupon): JsonResponse
    {
        $this->checkPermission('coupon_edit');
        $coupon->update([
            'is_active' => !$coupon->is_active
        ]);
        return $this->jsonResponse();
    }
}
