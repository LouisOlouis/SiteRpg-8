<?php

/**
 * Carrega variáveis do arquivo .env para $_ENV e getenv()
 * Uso: require_once 'env.php'; loadEnv(__DIR__ . '/.env');
 */
function loadEnv(string $path): void {
    if (!file_exists($path)) {
        throw new RuntimeException("Arquivo .env não encontrado em: $path");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // Ignora comentários
        if (str_starts_with(trim($line), '#')) continue;

        // Divide em chave=valor
        if (!str_contains($line, '=')) continue;

        [$key, $value] = explode('=', $line, 2);

        $key   = trim($key);
        $value = trim($value);

        // Remove aspas do valor ("valor" ou 'valor')
        if (
            (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
            (str_starts_with($value, "'") && str_ends_with($value, "'"))
        ) {
            $value = substr($value, 1, -1);
        }

        // Só define se ainda não estiver definido (não sobrescreve variáveis do servidor)
        if (!array_key_exists($key, $_ENV)) {
            $_ENV[$key]    = $value;
            putenv("$key=$value");
        }
    }
}