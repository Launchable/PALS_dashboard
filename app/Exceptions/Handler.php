<?php

namespace App\Exceptions;

use App\User;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
        /*if($this->isHttpException($exception))
        {
            switch ($exception->getStatusCode())
            {
                // not found
                case 404:
                    return redirect()->guest('login');
                    break;

                // internal error
                case '500':
                    return redirect()->guest('login');
                    break;
            }
        } */
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson() || $request->has('api_token') || !$request->header('Authorization')) {
            $response = [
                'status_code' => 401,
                'status' => 'error',
                'message' => 'Unauthorized to access resource.'
            ];
            return response()->json($response, 401);
        }
        else
        {
            $api_token = str_replace('Bearer ', '',$request->header('Authorization'));
            $user = User::where('api_token', $api_token)->count();
            if($user == 0)
            {
                $response = [
                    'status_code' => 401,
                    'status' => 'error',
                    'message' => 'Unauthorized to access resource.'
                ];
                return response()->json($response, 401);
            }
        }
        return redirect()->guest('login');
    }
}
