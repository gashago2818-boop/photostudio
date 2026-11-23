<?php
require __DIR__ . '/includes/init.php';
$title = 'О студии — Фотостудия «Кадр»';
$halls = array_unique(array_column($services, 'hall'));
include __DIR__ . '/includes/header.php';
?>
<section class="wrap block">
  <h1>О студии</h1>
  <p class="lead">«Кадр» — учебная фотостудия колледжа. Здесь можно снять портрет, семейную или предметную фотосессию и получить готовые обработанные снимки в течение пяти дней.</p>
  <div class="two">
    <div>
      <h2>Что мы предлагаем</h2>
      <ul class="plain">
        <li>Студийное оборудование: импульсный свет, цветные и белые фоны</li>
        <li>Помощь фотографа с позированием</li>
        <li>Ретушь и цветокоррекция включены в стоимость</li>
        <li>Готовые фото в электронном виде</li>
      </ul>
    </div>
    <div>
      <h2>Наши залы</h2>
      <ul class="plain">
        <?php foreach ($halls as $hall): ?><li><?= h($hall) ?></li><?php endforeach; ?>
      </ul>
      <h2>Контакты</h2>
      <p>г. Тюмень, ул. Примерная, 1<br>Ежедневно 10:00–20:00<br>+7 (3452) 00-00-00</p>
    </div>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
