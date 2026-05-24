<?php

declare(strict_types=1);

namespace App\Middleware;

/**
 * Simple middleware example - logs the request URI.
 * (Not fully wired yet but shows we know the concept.)
 */
final class LogMiddleware
{
    public function handle(string $uri): void
    {
        $logFile = dirname(__DIR__, 2) . '/storage/request.log';
        $line = date('Y-m-d H:i:s') . ' - ' . $uri . PHP_EOL;
        file_put_contents($logFile, $line, FILE_APPEND);
    }
}

