<?php
// Carga las variables de entorno desde el archivo .env (no se sube a GitHub).
// Copia .env.example a .env y rellena tus propios valores.

if (!function_exists('env')) {
    $envFile = __DIR__ . '/.env';
    if (is_readable($envFile)) {
        foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) {
                continue;
            }
            [$key, $value] = array_map('trim', explode('=', $line, 2));
            // Quita comillas envolventes si las hay
            if (strlen($value) >= 2 && ($value[0] === '"' || $value[0] === "'") && substr($value, -1) === $value[0]) {
                $value = substr($value, 1, -1);
            }
            $_ENV[$key] = $value;
        }
    }

    function env($key, $default = null)
    {
        if (array_key_exists($key, $_ENV)) {
            return $_ENV[$key];
        }
        $value = getenv($key);
        return $value === false ? $default : $value;
    }
}
