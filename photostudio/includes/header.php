<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= h(isset($title) ? $title : 'Фотостудия «Кадр»') ?></title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="top">
  <div class="wrap bar">
    <a class="logo" href="index.php"><span>◐</span> Кадр</a>
    <nav>
      <?php foreach (['index.php' => 'Главная', 'about.php' => 'О студии', 'services.php' => 'Услуги', 'schedule.php' => 'Расписание', 'shop.php' => 'Магазин'] as $url => $label): ?>
        <a href="<?= $url ?>" class="<?= $url === basename($_SERVER['SCRIPT_NAME']) ? 'on' : '' ?>"><?= $label ?></a>
      <?php endforeach; ?>
    </nav>
    <?php $__u = function_exists('current_user') ? current_user() : null; ?>
    <div class="auth">
      <?php if ($__u): ?>
        <a href="cabinet.php"><?= h($__u['name']) ?></a> <a href="logout.php">Выйти</a>
      <?php else: ?>
        <a href="login.php">Войти</a> <a href="register.php">Регистрация</a>
      <?php endif; ?>
    </div>
    <a class="cartlink" href="cart.php">Корзина<?php if (function_exists('cart_count') && cart_count() > 0): ?> <b><?= cart_count() ?></b><?php endif; ?></a>
    <a class="btn" href="book.php">Записаться</a>
  </div>
</header>
<main>
