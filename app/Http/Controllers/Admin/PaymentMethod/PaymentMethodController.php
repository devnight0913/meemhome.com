<?php

namespace App\Http\Controllers\Admin\PaymentMethod;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethodRequests\PaymentMethodStoreRequest;
use App\Http\Requests\PaymentMethodRequests\PaymentMethodUpdateRequest;
use App\Http\Resources\PaymentMethodResources\PaymentMethodResourceCollection;
use App\Models\PaymentMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class PaymentMethodController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse     
     */
    public function index(): JsonResponse
    {
        $this->checkPermission('payment_method_access');
        return $this->jsonResponse([
            'data' => new PaymentMethodResourceCollection(PaymentMethod::orderBy('name', 'ASC')->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PaymentMethodRequests\PaymentMethodStoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PaymentMethodStoreRequest $request): JsonResponse
    {
        $this->checkPermission('payment_method_create');
        PaymentMethod::create([
            'name' => $request->name,
            'active' => true,
        ]);
        Cache::forget(PaymentMethod::CACHE_KEY);
        return $this->jsonResponse();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PaymentMethodRequests\PaymentMethodUpdateRequest  $request
     * @param  \App\Models\PaymentMethod $paymentMethod
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PaymentMethodUpdateRequest $request, PaymentMethod $paymentMethod): JsonResponse
    {
        $this->checkPermission('payment_method_edit');
        $paymentMethod->update([
            'name' => $request->name,
        ]);
        Cache::forget(PaymentMethod::CACHE_KEY);
        return $this->jsonResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PaymentMethod $paymentMethod): JsonResponse
    {
        $this->checkPermission('payment_method_delete');
        $paymentMethod->delete();
        Cache::forget(PaymentMethod::CACHE_KEY);
        return $this->jsonResponse();
    }
}
