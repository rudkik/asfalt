<?php
$i = 0;
foreach ($data['view::_shop/return/item/one/esf']->childs as $value) {
    $i++;
    echo str_replace('$index$', $i, $value->str);
}
?>