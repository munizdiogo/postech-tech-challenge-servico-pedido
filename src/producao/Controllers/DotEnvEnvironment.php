<?php

namespace Controllers;

class DotEnvEnvironment
{
    public function load(): void
    {
        $lines = file("/var/www/html/.env");
        
        foreach ($lines as $line) {
            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            putenv(sprintf('%s=%s', $key, $value));
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}
