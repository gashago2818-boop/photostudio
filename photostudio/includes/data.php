<?php
// Данные сайта фотостудии «Кадр» (на этапе 2 хранятся в массивах; в пункте 4 переносятся в MySQL)
$services = [
    ['id' => 1, 'name' => 'Портретная съёмка',   'duration' => 60,  'price' => 3500, 'hall' => 'Зал «Свет»',  'desc' => 'Классический и студийный портрет, работа со светом и позированием.'],
    ['id' => 2, 'name' => 'Семейная фотосессия', 'duration' => 90,  'price' => 5500, 'hall' => 'Зал «Уют»',   'desc' => 'Съёмка для всей семьи в интерьере с живым светом.'],
    ['id' => 3, 'name' => 'Love Story',          'duration' => 90,  'price' => 5000, 'hall' => 'Зал «Уют»',   'desc' => 'Парная съёмка для влюблённых, подготовка образов и идей.'],
    ['id' => 4, 'name' => 'Предметная съёмка',   'duration' => 120, 'price' => 4500, 'hall' => 'Зал «Лайт»',  'desc' => 'Каталожные и имиджевые снимки товаров на светлом или цветном фоне.'],
    ['id' => 5, 'name' => 'Фото на документы',   'duration' => 20,  'price' => 600,  'hall' => 'Зал «Свет»',  'desc' => 'Быстрая съёмка по требованиям паспорта, визы и пропуска.'],
];

$schedule = [
    ['date' => '2026-11-18', 'time' => '10:00', 'service_id' => 1, 'free' => true],
    ['date' => '2026-11-18', 'time' => '12:30', 'service_id' => 5, 'free' => true],
    ['date' => '2026-11-18', 'time' => '15:00', 'service_id' => 2, 'free' => false],
    ['date' => '2026-11-19', 'time' => '11:00', 'service_id' => 4, 'free' => true],
    ['date' => '2026-11-19', 'time' => '14:00', 'service_id' => 3, 'free' => true],
    ['date' => '2026-11-20', 'time' => '10:00', 'service_id' => 1, 'free' => false],
    ['date' => '2026-11-20', 'time' => '16:00', 'service_id' => 2, 'free' => true],
    ['date' => '2026-11-21', 'time' => '12:00', 'service_id' => 3, 'free' => true],
];

function is_free($r) { return $r['free']; }
function find_service($services, $id) {
    foreach ($services as $s) { if ((int)$s['id'] === (int)$id) return $s; }
    return null;
}
function format_date($iso) {
    $days = ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'];
    $t = strtotime($iso);
    return date('d.m.Y', $t) . ', ' . $days[(int)date('w', $t)];
}
function h($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
