<?php
require __DIR__ . '/includes/init.php';
$title = 'Фотостудия «Кадр» — студийная съёмка в Тюмени';
// ближайшие свободные съёмки (первые 3)
$upcoming = array_slice(array_filter($schedule, 'is_free'), 0, 3);
include __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <div class="wrap">
    <h1>Свет, кадр, настроение</h1>
    <p>Фотостудия с тремя залами и профессиональным светом. Портреты, семейные и предметные съёмки.</p>
    <a class="btn big" href="book.php">Записаться</a>
  </div>
</section>
<section class="wrap block">
  <h2>Услуги</h2>
  <div class="grid">
    <?php foreach ($services as $s): ?>
      <article class="card">
        <div class="ph" style="--h:<?= $s['id'] * 52 ?>"></div>
        <h3><?= h($s['name']) ?></h3>
        <p class="muted"><?= h($s['hall']) ?> · <?= $s['duration'] ?> мин</p>
        <p class="price">от <?= number_format($s['price'], 0, '', ' ') ?> ₽</p>
      </article>
    <?php endforeach; ?>
  </div>
</section>
<section class="wrap block">
  <h2>Ближайшие свободные съёмки</h2>
  <ul class="list">
    <?php foreach ($upcoming as $r): $s = find_service($services, $r['service_id']); ?>
      <li><span><?= h(format_date($r['date'])) ?>, <?= h($r['time']) ?></span> <b><?= h($s['name']) ?></b> <em><?= h($s['hall']) ?></em>
        <a class="btn small" href="book.php">Записаться</a></li>
    <?php endforeach; ?>
  </ul>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
