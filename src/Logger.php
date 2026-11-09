<?php

class Logger {
    private static $logFile = __DIR__ . '/../logs/app.log';

    public static function log($mensagem, $nivel = 'INFO') {
        $dir = dirname(self::$logFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $timestamp = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $logFormatado = "[$timestamp] [$nivel] [IP: $ip] $mensagem" . PHP_EOL;

        file_put_contents(self::$logFile, $logFormatado, FILE_APPEND);
    }
}