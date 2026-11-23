<?php
require __DIR__ . '/includes/init.php';
require_login();
$user = current_user();
$services_db = db()->query('SELECT id, name, hall, duration, price FROM services ORDER BY id')->fetchAll();
$times = array('10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00');
$errors = array();
$sel_service = isset($_POST['service_id']) ? (int)$_POST['service_id'] : (isset($_GET['service']) ? (int)$_GET['service'] : 0);
$sel_date = isset($_POST['date']) ? $_POST['date'] : (isset($_GET['date']) ? $_GET['date'] : '');
$sel_time = isset($_POST['time']) ? $_POST['time'] : (isset($_GET['time']) ? $_GET['time'] : '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = trim($_POST['comment']);
    $d = DateTime::createFromFormat('Y-m-d', $sel_date);
    $service_ok = false;
    foreach ($services_db as $s) { if ((int)$s['id'] === $sel_service) $service_ok = true; }

    if (!$service_ok)                                   $errors[] = 'Выберите услугу.';
    if (!$d || $d->format('Y-m-d') !== $sel_date)       $errors[] = 'Укажите дату съёмки.';
    elseif ($sel_date < date('Y-m-d'))                  $errors[] = 'Нельзя записаться на прошедшую дату.';
    if (!in_array($sel_time, $times, true))             $errors[] = 'Выберите время съёмки.';
    if (mb_strlen($comment) > 255)                      $errors[] = 'Комментарий не длиннее 255 символов.';

    if (!$errors) {
        $st = db()->prepare("SELECT COUNT(*) FROM bookings WHERE shoot_date = ? AND shoot_time = ? AND status <> 'cancelled'");
        $st->execute(array($sel_date, $sel_time . ':00'));
        if ($st->fetchColumn() > 0) {
            $errors[] = 'Это время уже занято, выберите другое.';
        } else {
            $st = db()->prepare('INSERT INTO bookings (user_id, service_id, shoot_date, shoot_time, comment) VALUES (?, ?, ?, ?, ?)');
            $st->execute(array($user['id'], $sel_service, $sel_date, $sel_time . ':00', $comment));
            $_SESSION['flash'] = 'Заявка отправлена. Мы свяжемся с вами для подтверждения.';
            header('Location: cabinet.php');
            exit;
        }
    }
}
$title = 'Запись на съёмку — Фотостудия «Кадр»';
include __DIR__ . '/includes/header.php';
?>
<section class="wrap block">
  <h1>Запись на съёмку</h1>
  <form class="form" method="post" action="book.php" novalidate>
    <?php if ($errors): ?><div class="err"><ul><?php foreach ($errors as $e): ?><li><?= h($e) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
    <label for="service_id">Услуга</label>
    <select id="service_id" name="service_id">
      <option value="0">— выберите —</option>
      <?php foreach ($services_db as $s): ?>
        <option value="<?= (int)$s['id'] ?>" <?= $sel_service === (int)$s['id'] ? 'selected' : '' ?>><?= h($s['name']) ?> — <?= (int)$s['price'] ?> ₽</option>
      <?php endforeach; ?>
    </select>
    <label for="date">Дата</label><input id="date" name="date" type="date" min="<?= date('Y-m-d') ?>" value="<?= h($sel_date) ?>">
    <label for="time">Время</label>
    <select id="time" name="time">
      <option value="">— выберите —</option>
      <?php foreach ($times as $t): ?><option value="<?= $t ?>" <?= $sel_time === $t ? 'selected' : '' ?>><?= $t ?></option><?php endforeach; ?>
    </select>
    <label for="comment">Комментарий</label><textarea id="comment" name="comment" rows="3"><?= old('comment') ?></textarea>
    <button class="btn" type="submit">Отправить заявку</button>
  </form>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
