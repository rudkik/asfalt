<?php
$i = 1;
foreach ($data['view::_shop/bill/item/one/payment-source']->childs as $value) {
    echo str_replace('#index#', $i++, $value->str);
}
?>