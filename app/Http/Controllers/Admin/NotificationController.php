<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResources\NotificationResourceCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * List of all notifications.
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->jsonResponse(['data' => $this->userNotifications()]);
    }

    /**
     * List of all user's notifications.
     *
     * @return \App\Http\Resources\NotificationResources\NotificationResourceCollection
     */
    private function userNotifications(): NotificationResourceCollection
    {
        return new NotificationResourceCollection(
            Auth::user()->notifications->map(function ($notification) {
                return [
                    'data'         => $notification->data['data'],
                    'url'          => $notification->data['url'] ?? '',
                    'created_at'     => $notification->created_at->diffForHumans(),
                ];
            })
        );
    }

    /**
     * Mark all user's listing of the resource as read.
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function markAsRead(): JsonResponse
    {
        Auth::user()->unreadNotifications->markAsRead();
        return $this->jsonResponse();
    }

    /**
     * Count all unread notifications.
     *
     * @return int
     */
    public function unread(): int
    {
        return Auth::user()->unreadNotifications->count();
    }
}
