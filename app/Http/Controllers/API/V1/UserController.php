<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * show user.
     *
     */
    public function show(Request $request)
    {
        return $this->jsonResponse([
            "user" => $request->user('api'),
        ]);
    }
}
