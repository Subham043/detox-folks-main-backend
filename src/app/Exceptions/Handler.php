<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, HttpException|Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => $exception->getMessage()
                ], $exception->getStatusCode());
            }
            return $this->customRender(
                $exception,
                $exception->getStatusCode(),
                $exception->getMessage(),
                $exception->getHeaders()
            );
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => $exception->getMessage()
                ], $exception->getStatusCode());
            }
            return $this->customRender(
                $exception,
                Response::HTTP_METHOD_NOT_ALLOWED,
                $exception->getMessage()
            );
        }

        if ($exception instanceof ModelNotFoundException) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => "Data not found."
                ], 404);
            }
            return $this->customRender(
                $exception,
                Response::HTTP_NOT_FOUND,
                'No data found'
            );
        }

        if ($exception instanceof NotFoundHttpException) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Data not found.'
                ], $exception->getStatusCode());
            }
            return $this->customRender(
                $exception,
                Response::HTTP_NOT_FOUND,
                $exception->getMessage(),
                $exception->getHeaders()
            );
        }


        return parent::render($request, $exception);
    }

    private function customRender($exception, $status_code, $message, $headers = []){
        if(Auth::check()){
            return $this->sendErrorResponse($exception, $status_code, $message, $headers, 'errors.admin.authenticated_error');
        }else{
            return $this->sendErrorResponse($exception, $status_code, $message, $headers, 'errors.admin.unauthenticated_error');
        }
    }

    private function sendErrorResponse($exception, $status_code, $message, $headers, $view, $data = []){
        return response()
            ->view($view,
                [
                    ...$data,
                    'exception' => $exception,
                    'status_code' => $status_code,
                    'message' => $message
                ],
                $status_code,
                $headers
            );
    }
}
