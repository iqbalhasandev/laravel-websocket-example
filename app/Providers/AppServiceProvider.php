<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($data = null, $message = null, $code = 200)
        {
            return Response::json([
                'success' => true,
                'data'    => $data,
                'message' => $message,
                JSON_PRESERVE_ZERO_FRACTION,
            ], $code);
        });

        Response::macro('error', function ($data = null, $message = null, $code = 400)
        {
            return Response::json([
                'success' => false,
                'data'    => $data,
                'message' => $message,
                JSON_PRESERVE_ZERO_FRACTION,
            ], $code);
        });

    }
}
