<?php

namespace App\Exceptions;

use App\Http\Controllers\ApiController;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     * @throws \ReflectionException
     */
    public function render($request, Exception $exception)
    {
        //return parent::render($request, $exception);

        $exceptionClass = (new \ReflectionClass($exception))->getShortName();
        $message = "Something went wrong on server";
        $debugMode = config('app.debug', false);

        switch ($exceptionClass) {
            case 'HttpResponseException':
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;
                break;

            case 'MethodNotAllowedHttpException':
                $status = Response::HTTP_METHOD_NOT_ALLOWED;
                $message = "Route has been used with wrong method";
                break;

            case 'ModelNotFoundException':
                $status = Response::HTTP_METHOD_NOT_ALLOWED;
                $message = $debugMode ? $exception->getMessage() : "No result found";
                break;

            case 'NotFoundHttpException':
                $status = Response::HTTP_NOT_FOUND;
                $message = "Requested route has not found";
                break;

            case 'AuthorizationException':
                $status = Response::HTTP_FORBIDDEN;
                $message = $exception->getMessage() ?? "Wrong or invalid parameter provided";
                break;

            case 'ValidatorException':
                $status = Response::HTTP_BAD_REQUEST;
                $message = "Wrong or invalid parameter provided";
                break;

            case 'InvalidArgumentException':
            case 'InvalidException':
                $status = Response::HTTP_BAD_REQUEST;
                $message = $exception->getMessage();
                break;

            case 'QueryException':
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;
                $message = $debugMode ? $exception->getMessage() : $message;
                break;

            case 'AuthException':
                $status = Response::HTTP_UNAUTHORIZED;
                $message = $exception->getMessage();
                break;

            case 'ValidationException':
                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
                $message = json_decode($exception->getResponse()->getContent(), 1);
                break;

            default:
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;
                $message = $debugMode ? $exception->getMessage() : $message;
                break;
        }
        if (!is_array($message)) {
            $message = ['error' => [$message]];
        }
        return app(ApiController::class)->sendError($exceptionClass, (array)$message, $status);
    }
}
