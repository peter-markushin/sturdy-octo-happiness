<?php

namespace App\Infrastructure\Laravel\Exceptions;

use App\Domain\Shared\Exception\DomainException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * This is your application's exception handler
 *
 * Class Handler
 */
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
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): Response
    {
        if ($request->is('api/*')) {
            $httpCode = match (true) {
                $e instanceof ValidationException => Response::HTTP_BAD_REQUEST,
                $e instanceof HttpExceptionInterface => $e->getStatusCode(),
                default => Response::HTTP_INTERNAL_SERVER_ERROR,
            };

            return response()->json([
                'date' => date('Y-m-d H:i:s'),
                'trace' => $e->getTrace(),
                'message' => $e->getMessage(),
                'at' => $e->getFile() . ':' . $e->getLine(),
            ], $httpCode);
        }

        if ($e instanceof TokenMismatchException) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['Oops! Seems you could not submit form for a long time.']);
        }

        if ($e instanceof DomainException) {
            return redirect()->back()
                ->withInput()
                ->withErrors([$e->getMessage()]);
        }

        if ($e instanceof ThrottleRequestsException) {
            if ($request->method() !== Request::METHOD_GET) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['Too many requests. Please try again later.']);
            }
        }

        return parent::render($request, $e);
    }
}
