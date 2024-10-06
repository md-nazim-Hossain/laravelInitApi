<?php

namespace App\Exceptions;

use Dotenv\Exception\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    // public function register(): void
    // {
    //     $this->reportable(function (Throwable $e) {
    //         //
    //     });
    // }

    public function render($request, Throwable $exception){

        if($exception instanceof APIException){
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], $exception->getCode());
        }
         if($exception instanceof ModelNotFoundException){
            return response()->json([
                'message' => 'Resource not found',
                'success' => false
            ], 404);
        }
         if($exception instanceof AuthorizationException){
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], $exception->getCode());
        }
        if($exception instanceof ValidationException){
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 422);
        }
         if ($exception instanceof \BadMethodCallException) {
            return response()->json( [
                'success' => 0,
                'message' => 'Bad Method Called',
                'status' => '404',
            ], 404 );
        }

        if($exception instanceof TokenMismatchException){
            return response()->json([
                'message' => 'Token has expired',
                'success' => false
            ], 401);
        }


        if($exception instanceof NotFoundHttpException){
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 404);
        }
        return parent::render($request, $exception);

    }
}
