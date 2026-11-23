<?php
require __DIR__ . '/includes/init.php';
$title = 'Расписание съёмок — Фотостудия «Кадр»';
// группировка расписания по датам
$byDate = [];
foreach ($schedule as $r) { $byDate[$r['date']][] = $r; }
ksort($byDate);
include __DIR__ . '/includes/header.php';
?>
<section class="wrap block">
  <h1>Расписание съёмок</h1>
  <?php if (!$byDate): ?>
    <p>Свободных съёмок пока нет.</p>
  <?php endif; ?>
  <?php foreach ($byDate as $date => $rows): ?>
    <h2 class="day"><?= h(format_date($date)) ?></h2>
    <table class="tbl sch">
      <?php foreach ($rows as $r): $s = find_service($services, $r['service_id']); ?>
        <tr>
          <td class="time"><?= h($r['time']) ?></td>
          <td><b><?= h($s['name']) ?></b><br><span class="muted"><?= h($s['hall']) ?> · <?= $s['duration'] ?> мин</span></td>
          <td><?= number_format($s['price'], 0, '', ' ') ?> ₽</td>
          <td><?= $r['free'] ? '<span class="ok">Свободно</span>' : '<span class="busy">Занято</span>' ?></td>
          <td><?php if ($r['free']): ?><a class="btn small" href="book.php?date=<?= h($r['date']) ?>&amp;time=<?= h($r['time']) ?>&amp;service=<?= (int)$r['service_id'] ?>">Записаться</a><?php endif; ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endforeach; ?>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
