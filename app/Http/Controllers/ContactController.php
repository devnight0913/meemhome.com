<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use App\Models\Settings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Show contact page.
     *
     * @return \Illuminate\View\View
     */
    public function show(): View
    {
        return view('contact.show', [
            'address' => Settings::getAddressValue(),
            'email' => Settings::getEmailValue(),
            'phone' => Settings::getPhoneValue(),
            'gm_share_link' =>  Settings::getGoogleMapsShareLinkValue(),
            'gm_iframe' => Settings::getGoogleMapsIFrameValue(),
        ]);
    }

    /**
     * Send message mail.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(ContactRequest $request): JsonResponse
    {
        Mail::to(Settings::getAdminEmailValue())->send(new ContactMail($request));
        return new JsonResponse(['message' => 'Message sent'], Response::HTTP_OK);
    }
}
