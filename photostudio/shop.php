<?php
require __DIR__ . '/includes/init.php';
$title = 'Магазин фотопродукции — Фотостудия «Кадр»';
$notice = flash();
include __DIR__ . '/includes/header.php';
?>
<section class="wrap block">
  <h1>Магазин фотопродукции</h1>
  <?php if ($notice): ?><div class="note"><?= h($notice) ?> <a href="cart.php">Перейти в корзину</a></div><?php endif; ?>
  <div class="shop">
    <?php foreach ($products as $p): ?>
      <article class="card">
        <div class="ph" style="--h:<?= $p['id'] * 41 ?>"></div>
        <h3><?= h($p['name']) ?></h3>
        <p class="muted"><?= h($p['desc']) ?></p>
        <p class="price"><?= money($p['price']) ?></p>
        <form method="post" action="cart.php">
          <input type="hidden" name="action" value="add">
          <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
          <button class="btn small" type="submit">В корзину</button>
        </form>
      </article>
    <?php endforeach; ?>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
