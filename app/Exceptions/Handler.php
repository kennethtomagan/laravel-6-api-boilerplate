<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // return parent::render($request, $exception);

        $rendered = parent::render($request, $exception);

        if ($exception instanceof ValidationException) {
            $json = [
                'error' => $exception->validator->errors(),
                'status_code' => $rendered->getStatusCode()
            ];
        } elseif ($exception instanceof AuthorizationException) {
            $json = [
                'error' => 'You are not allowed to do this action.',
                'status_code' => 403
            ];
        }
        else {
            // Default to vague error to avoid revealing sensitive information
            $json = [
                'error' => (app()->environment() !== 'production')
                    ? $exception->getMessage()
                    : 'An error has occurred.',
                'status_code' => $exception->getCode()
            ];
        }

        return response()->json($json, $rendered->getStatusCode());
    }
}
