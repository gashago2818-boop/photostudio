<?php
require __DIR__ . '/includes/init.php';
if (current_user()) { header('Location: cabinet.php'); exit; }
$errors = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $st = db()->prepare('SELECT id, password_hash FROM users WHERE email = ?');
    $st->execute(array($email));
    $u = $st->fetch();
    if ($u && password_verify($_POST['password'], $u['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int)$u['id'];
        header('Location: cabinet.php');
        exit;
    }
    $errors[] = 'Неверный email или пароль.';
}
$notice = flash();
$title = 'Вход — Фотостудия «Кадр»';
include __DIR__ . '/includes/header.php';
?>
<section class="wrap block">
  <h1>Вход</h1>
  <form class="form" method="post" action="login.php" novalidate>
    <?php if ($notice): ?><div class="note"><?= h($notice) ?></div><?php endif; ?>
    <?php if ($errors): ?><div class="err"><ul><?php foreach ($errors as $e): ?><li><?= h($e) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
    <label for="email">Email</label><input id="email" name="email" type="email" value="<?= old('email') ?>">
    <label for="password">Пароль</label><input id="password" name="password" type="password">
    <button class="btn" type="submit">Войти</button>
    <p class="hint">Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
  </form>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
