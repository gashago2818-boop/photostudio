<?php
// Настройки подключения к MySQL (OpenServer: пользователь root, пароль пустой)
$dsn = getenv('PHOTO_DSN');
return array(
    'dsn'  => $dsn ? $dsn : 'mysql:host=localhost;dbname=photostudio;charset=utf8mb4',
    'user' => 'root',
    'pass' => '',
);
