<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                // Error log.
                Log::error($e);

                // Exclusive lock exception (status: 409).
                if ($e instanceof ExclusiveLockException) {
                    return response()->json([
                        'message' => $e->getMessage() ? $e->getMessage() : 'Exculive lock error.',
                    ], Response::HTTP_CONFLICT);
                }

                // Server error (status: 500).
                return response()->json([
                    'message' => $e->getMessage() ? $e->getMessage() : 'Internal server error.',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
    }
}
