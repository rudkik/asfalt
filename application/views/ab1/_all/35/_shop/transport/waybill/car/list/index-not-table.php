<?php
$i = 1;
foreach ($data['view::_shop/transport/waybill/car/one/index']->childs as $value) {
    echo str_replace('#index#', $i++, $value->str);
}
?>