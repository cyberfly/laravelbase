<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Resources\Common\UserNotificationResource;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class UserNotificationController extends Controller
{
    public function __construct(

    ) {

    }

    public function index()
    {
        return view('usernotifications.index');
    }

    public function show($id)
    {
        $notification = DatabaseNotification::where('id', $id)->firstOrFail();

        if ($notification) {

            // mark as read

            $notification->markAsRead();

            // redirect to specific url

            $action_url = data_get($notification->data, 'action_url', null);

            if (!empty($action_url)) {
                return redirect($action_url);
            }
        }
    }

    public function getUserNotifications()
    {
        $user_notifications = auth()->user()->notifications()->result();

        return new UserNotificationResource($user_notifications);
    }
}
