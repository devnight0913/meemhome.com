<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Response represents an HTTP response in JSON format.
     *
     * @param mixed $data
     * @param int   $status
     * @param array $headers
     * @param int   $options
     * @param bool  $json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonResponse(
        $data = null,
        $status = 200,
        $headers = [],
        $options = 0,
        $json = false
    ): JsonResponse {
        $data['status'] = Str::lower(Response::$statusTexts[$status]);
        // $data['code'] = $status;
        return new JsonResponse($data, $status, $headers, $options, $json);
    }


    public static function generateSlug()
    {
        $cleanNumber = preg_replace('/[^0-9]/', '', microtime(false));
        $slug = base_convert($cleanNumber, 10, 36) . "" . Str::lower(Str::random(3)) . "" . rand(1, 999);
        return $slug;
    }


    public  function checkPermission(string $permission)
    {
        abort_if(!$this->authUser()->hasPermissionTo($permission), Response::HTTP_UNAUTHORIZED);
    }

    public  function authUser(): User|null
    {
        return Auth::user();
    }
}
