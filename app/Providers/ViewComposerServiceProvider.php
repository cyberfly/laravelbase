<?php

namespace App\Providers;

use App\Traits\PhpToJsVars;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use ExportLocalization;
use JavaScript;

class ViewComposerServiceProvider extends ServiceProvider
{
    use PhpToJsVars;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // load PHP to JS variables

        JavaScript::put($this->getPhpToJsVariables());

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
