<?php
// Общая инициализация: сессия, данные, подключение к БД, вспомогательные функции
session_start();
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/products.php';

function current_user() {
    if (empty($_SESSION['user_id'])) return null;
    $st = db()->prepare('SELECT id, name, email, phone, created_at FROM users WHERE id = ?');
    $st->execute(array($_SESSION['user_id']));
    $u = $st->fetch();
    return $u ? $u : null;
}
function require_login() {
    if (!current_user()) {
        $_SESSION['flash'] = 'Войдите в личный кабинет, чтобы продолжить.';
        header('Location: login.php');
        exit;
    }
}
function flash() {
    if (isset($_SESSION['flash'])) {
        $m = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $m;
    }
    return '';
}
function old($key) { return isset($_POST[$key]) ? h($_POST[$key]) : ''; }
