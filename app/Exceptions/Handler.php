<?php

namespace App\Exceptions;

use App\Models\LogApi;
use App\Traits\ApiResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
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
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // LogApi::create([
            //     'url' => Request::url(),
            //     'body' => $e,
            //     'fire_base_result' => '',
            //     'userFireBaseTokens' => '',
            // ]);
        });
    }

    use ApiResponseTrait;

    public function render($request, Throwable $e)
    {
        if ($request->is('api/*') || $request->wantsJson()) {
            return $this->handleApiException($request, $e);
        }

        return parent::render($request, $e);
    }

    private function handleApiException($request, Throwable $e)
    {
        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        }

        $exception = $this->prepareException($e);

        if ($exception instanceof ValidationException) {
            return $this->errorResponse($exception->validator->errors()->first(), 422, $exception->validator->errors());
        }

        if ($exception instanceof AuthenticationException) {
            return $this->errorResponse('Unauthenticated', 401);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('Route not found', 404);
        }

        $message = $exception->getMessage();
        $code = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;

        // If it's a server error and debug is off, hide details
        if ($code == 500 && ! config('app.debug')) {
            $message = 'Server Error';
        }

        return $this->errorResponse($message, $code);
    }
}
