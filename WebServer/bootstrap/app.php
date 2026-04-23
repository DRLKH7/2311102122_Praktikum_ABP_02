<?php
if (!function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        return dirname(__DIR__) . ($path ? DIRECTORY_SEPARATOR . $path : '');
    }
}

if (!function_exists('env')) {
    function env(string $key, $default = null)
    {
        static $values = null;

        if ($values === null) {
            $values = [];
            $envFile = base_path('.env');

            if (file_exists($envFile)) {
                $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '' || $line[0] === '#') {
                        continue;
                    }

                    $parts = explode('=', $line, 2);
                    if (count($parts) === 2) {
                        $values[trim($parts[0])] = trim($parts[1]);
                    }
                }
            }
        }

        return $values[$key] ?? $default;
    }
}

$config = require base_path('config/app.php');
