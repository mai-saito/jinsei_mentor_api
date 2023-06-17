<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ApiErrorResponseProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Response for errors/exceptions.
        Response::macro('error', function (int $status_code, string $message) {
            return Response::json([
                'message' => $message,
            ], $status_code);
        });
    }
}
