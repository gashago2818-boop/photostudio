<?php
require __DIR__ . '/includes/init.php';
require_login();
$user = current_user();
$st = db()->prepare('SELECT b.id, b.shoot_date, b.shoot_time, b.comment, b.status, s.name AS service, s.hall, s.price
                     FROM bookings b JOIN services s ON s.id = b.service_id
                     WHERE b.user_id = ? ORDER BY b.shoot_date, b.shoot_time');
$st->execute(array($user['id']));
$rows = $st->fetchAll();
$statuses = array('new' => 'Новая', 'confirmed' => 'Подтверждена', 'cancelled' => 'Отменена');
$notice = flash();
$title = 'Личный кабинет — Фотостудия «Кадр»';
include __DIR__ . '/includes/header.php';
?>
<section class="wrap block">
  <h1>Личный кабинет</h1>
  <?php if ($notice): ?><div class="note"><?= h($notice) ?></div><?php endif; ?>
  <p><b><?= h($user['name']) ?></b><br><span class="muted"><?= h($user['email']) ?> · <?= h($user['phone']) ?></span></p>
  <h2 class="day">Мои заявки</h2>
  <?php if (!$rows): ?>
    <p>У вас пока нет заявок. <a href="book.php">Записаться на съёмку</a></p>
  <?php else: ?>
    <table class="tbl">
      <thead><tr><th>Дата и время</th><th>Услуга</th><th>Цена</th><th>Статус</th></tr></thead>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= h(format_date($r['shoot_date'])) ?>, <?= h(substr($r['shoot_time'], 0, 5)) ?></td>
          <td><b><?= h($r['service']) ?></b><br><span class="muted"><?= h($r['hall']) ?><?= $r['comment'] ? ' · ' . h($r['comment']) : '' ?></span></td>
          <td><?= (int)$r['price'] ?> ₽</td>
          <td><span class="st"><?= h(isset($statuses[$r['status']]) ? $statuses[$r['status']] : $r['status']) ?></span></td>
        </tr>
      <?php endforeach; ?>
    </table>
    <a class="btn" href="book.php">Новая заявка</a>
  <?php endif; ?>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
