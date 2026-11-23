<?php
require __DIR__ . '/includes/init.php';
if (current_user()) { header('Location: cabinet.php'); exit; }
$errors = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $pass  = $_POST['password'];
    $pass2 = $_POST['password2'];

    if (mb_strlen($name) < 2)                          $errors[] = 'Введите имя (не короче 2 символов).';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))    $errors[] = 'Введите корректный email.';
    if (!preg_match('/^\+?[0-9\s\-()]{10,18}$/', $phone)) $errors[] = 'Введите телефон в формате +7 900 000-00-00.';
    if (strlen($pass) < 6)                             $errors[] = 'Пароль должен быть не короче 6 символов.';
    if ($pass !== $pass2)                              $errors[] = 'Пароли не совпадают.';

    if (!$errors) {
        $st = db()->prepare('SELECT id FROM users WHERE email = ?');
        $st->execute(array($email));
        if ($st->fetch()) {
            $errors[] = 'Пользователь с таким email уже зарегистрирован.';
        } else {
            $st = db()->prepare('INSERT INTO users (name, email, phone, password_hash) VALUES (?, ?, ?, ?)');
            $st->execute(array($name, $email, $phone, password_hash($pass, PASSWORD_DEFAULT)));
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int)db()->lastInsertId();
            $_SESSION['flash'] = 'Регистрация прошла успешно. Добро пожаловать!';
            header('Location: cabinet.php');
            exit;
        }
    }
}
$title = 'Регистрация — Фотостудия «Кадр»';
include __DIR__ . '/includes/header.php';
?>
<section class="wrap block">
  <h1>Регистрация</h1>
  <form class="form" method="post" action="register.php" novalidate>
    <?php if ($errors): ?><div class="err"><ul><?php foreach ($errors as $e): ?><li><?= h($e) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
    <label for="name">Имя</label><input id="name" name="name" value="<?= old('name') ?>">
    <label for="email">Email</label><input id="email" name="email" type="email" value="<?= old('email') ?>">
    <label for="phone">Телефон</label><input id="phone" name="phone" value="<?= old('phone') ?>" placeholder="+7 900 000-00-00">
    <label for="password">Пароль</label><input id="password" name="password" type="password">
    <label for="password2">Повторите пароль</label><input id="password2" name="password2" type="password">
    <button class="btn" type="submit">Зарегистрироваться</button>
    <p class="hint">Уже есть аккаунт? <a href="login.php">Войти</a></p>
  </form>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
