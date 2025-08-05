<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use jeremykenedy\LaravelRoles\App\Exceptions\LevelDeniedException;
use jeremykenedy\LaravelRoles\App\Exceptions\PermissionDeniedException;
use jeremykenedy\LaravelRoles\App\Exceptions\RoleDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /** @var array */
    protected $dontReport = [];

    /** @var array */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $exception): void
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception): Response
    {
        $userLevelCheck = $exception instanceof RoleDeniedException ||
            $exception instanceof PermissionDeniedException ||
            $exception instanceof LevelDeniedException;
        if ($userLevelCheck) {
            return redirect()->back()
                ->with(
                    'error',
                    'You have no permission to access this page.'
                );
        }

        return parent::render($request, $exception);
    }
}
