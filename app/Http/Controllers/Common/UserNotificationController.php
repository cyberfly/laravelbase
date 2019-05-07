<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class UserNotificationController extends Controller
{
    public function __construct(

    ) {

    }

    public function index()
    {
        $user_notifications = auth()->user()->notifications;

        return $user_notifications;
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
}
