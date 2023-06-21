<?php

namespace App\Exceptions;

use Closure;
use GraphQL\Error\Error;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use PDOException;

class LighthouseExceptionHandler extends ExceptionHandler
{
    public function __invoke(?Error $error, Closure $next): ?array
    {
        if ($error === null) {
            return $next(null);
        }

        if ($error->getPrevious() instanceof PDOException) {
            return $next(new Error(__('SQL error occured')));
        }

        return $next(new Error(__($error->getMessage())));
    }
}
