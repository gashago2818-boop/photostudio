<?php
// Подключение к базе данных через PDO
function db() {
    static $pdo = null;
    if ($pdo === null) {
        $cfg = require __DIR__ . '/../config.php';
        $pdo = new PDO($cfg['dsn'], $cfg['user'], $cfg['pass'], array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ));
    }
    return $pdo;
}
