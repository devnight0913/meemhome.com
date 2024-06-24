<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use App\Models\Settings;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class TestEmailController extends Controller
{
    public function testPrimaryEmail()
    {
        $adminEmail = Settings::getAdminEmailValue();
        try {
            Mail::to($adminEmail)->send(new TestMail());
            return $this->jsonResponse([
                'email' => $adminEmail
            ]);
        } catch (Exception $e) {
            return $e;
            return $this->jsonResponse([
                'message' => $e
            ], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
}
