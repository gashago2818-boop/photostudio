<?php
$products = array(
    array('id' => 1, 'name' => 'Фоторамка деревянная 20×30', 'price' => 650,  'desc' => 'Рамка из массива сосны со стеклом.'),
    array('id' => 2, 'name' => 'Фотоальбом, 20 страниц',     'price' => 1200, 'desc' => 'Альбом с плотными листами и обложкой из ткани.'),
    array('id' => 3, 'name' => 'Фотокнига 30×30',            'price' => 2900, 'desc' => 'Печать ваших снимков на плотной бумаге, твёрдый переплёт.'),
    array('id' => 4, 'name' => 'Печать фото 10×15, 10 шт.',  'price' => 250,  'desc' => 'Глянцевая или матовая бумага на выбор.'),
    array('id' => 5, 'name' => 'Фото на холсте 40×60',       'price' => 2400, 'desc' => 'Печать на холсте на подрамнике.'),
    array('id' => 6, 'name' => 'Подарочный сертификат',      'price' => 3000, 'desc' => 'Сертификат на любую фотосъёмку в студии.'),
    array('id' => 7, 'name' => 'Фотомагниты, набор 4 шт.',   'price' => 450,  'desc' => 'Магниты на холодильник из ваших фотографий.'),
    array('id' => 8, 'name' => 'Фотокружка',                 'price' => 700,  'desc' => 'Керамическая кружка с вашим снимком.'),
);

function find_product($products, $id) {
    foreach ($products as $p) { if ((int)$p['id'] === (int)$id) return $p; }
    return null;
}
// Корзина хранится в сессии: массив «id товара => количество»
function cart_items() {
    return isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : array();
}
function cart_count() {
    return array_sum(cart_items());
}
function money($n) { return number_format($n, 0, '', ' ') . ' ₽'; }
