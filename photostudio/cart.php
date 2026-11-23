<?php
require __DIR__ . '/includes/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $id     = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $cart   = cart_items();
    $p      = find_product($products, $id);

    if ($action === 'add' && $p) {
        $cart[$id] = (isset($cart[$id]) ? $cart[$id] : 0) + 1;
        if ($cart[$id] > 99) $cart[$id] = 99;
        $_SESSION['cart'] = $cart;
        $_SESSION['flash'] = 'Товар «' . $p['name'] . '» добавлен в корзину.';
        header('Location: shop.php');
        exit;
    }
    if ($action === 'update' && $p) {
        $q = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
        if ($q < 1)  { unset($cart[$id]); }
        else         { $cart[$id] = min($q, 99); }
    }
    if ($action === 'remove') { unset($cart[$id]); }
    if ($action === 'clear')  { $cart = array(); }
    $_SESSION['cart'] = $cart;
    header('Location: cart.php');
    exit;
}

$lines = array();
$total = 0;
foreach (cart_items() as $pid => $qty) {
    $p = find_product($products, $pid);
    if (!$p) continue;
    $sum = $p['price'] * $qty;
    $total += $sum;
    $lines[] = array('p' => $p, 'qty' => $qty, 'sum' => $sum);
}
$title = 'Корзина — Фотостудия «Кадр»';
include __DIR__ . '/includes/header.php';
?>
<section class="wrap block">
  <h1>Корзина</h1>
  <?php if (!$lines): ?>
    <p>Корзина пуста. <a href="shop.php">Перейти в магазин</a></p>
  <?php else: ?>
    <table class="tbl">
      <thead><tr><th>Товар</th><th>Цена</th><th>Количество</th><th>Сумма</th><th></th></tr></thead>
      <?php foreach ($lines as $l): ?>
        <tr>
          <td><b><?= h($l['p']['name']) ?></b></td>
          <td><?= money($l['p']['price']) ?></td>
          <td>
            <form method="post" action="cart.php" style="display:flex;gap:6px">
              <input type="hidden" name="action" value="update">
              <input type="hidden" name="id" value="<?= (int)$l['p']['id'] ?>">
              <input class="qty" type="number" name="qty" min="0" max="99" value="<?= (int)$l['qty'] ?>">
              <button class="btn small light" type="submit">Обновить</button>
            </form>
          </td>
          <td><b><?= money($l['sum']) ?></b></td>
          <td>
            <form method="post" action="cart.php">
              <input type="hidden" name="action" value="remove">
              <input type="hidden" name="id" value="<?= (int)$l['p']['id'] ?>">
              <button class="linkbtn" type="submit">Удалить</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
    <div class="total">Итого: <?= money($total) ?></div>
    <div class="actions">
      <form method="post" action="cart.php"><input type="hidden" name="action" value="clear"><button class="linkbtn" type="submit">Очистить корзину</button></form>
      <a class="btn light" href="shop.php">Продолжить покупки</a>
    </div>
  <?php endif; ?>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
