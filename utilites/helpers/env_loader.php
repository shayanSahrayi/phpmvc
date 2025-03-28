<?php

function loadEnv($filePath)
{
     if (!file_exists($filePath)) {
        throw new Exception("Fata .env file does not exist");
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // حذف کامنت‌ها
        $line = trim($line);
        if (empty($line) || $line[0] == '#') {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);

        $key = trim($key);
        $value = trim($value);

        putenv("$key=$value");
    }
}
loadEnv('C:\xamp81\htdocs\.env');
