<?php
require __DIR__ . '/includes/init.php';
$title = 'Услуги и цены — Фотостудия «Кадр»';
include __DIR__ . '/includes/header.php';
?>
<section class="wrap block">
  <h1>Услуги и цены</h1>
  <table class="tbl">
    <thead><tr><th>Услуга</th><th>Зал</th><th>Длительность</th><th>Цена</th></tr></thead>
    <tbody>
    <?php foreach ($services as $s): ?>
      <tr>
        <td><b><?= h($s['name']) ?></b><br><span class="muted"><?= h($s['desc']) ?></span></td>
        <td><?= h($s['hall']) ?></td>
        <td><?= $s['duration'] ?> мин</td>
        <td><?= number_format($s['price'], 0, '', ' ') ?> ₽</td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
