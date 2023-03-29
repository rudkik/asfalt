<?php
$i = 0;
foreach ($data['view::_shop/invoice/item/gtd/one/invoice']->childs as $value) {
    $i++;
    echo str_replace('#index#', $i, $value->str);
}
?>