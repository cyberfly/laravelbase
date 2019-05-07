<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use ExportLocalization;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // load Laravel Localization to Vue messages

        View::composer('*', function ($view) {
            return $view->with([
                'messages' => ExportLocalization::export()->toFlat(),
            ]);
        });

        // load user notifications summary

        View::composer('*', function ($view) {

            $user = auth()->user();

            if ($user) {
                $user_notifications = $user->unreadNotifications;

                $unread_count = $user_notifications->count();
            }
            else {
                $user_notifications = [];

                $unread_count = 0;
            }

            return $view->with([
                'user_notifications' => $user_notifications,
                'unread_count' => $unread_count,
            ]);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
