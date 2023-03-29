
<?php
$i = 0;
foreach ($data['view::_shop/realization/item/one/invoice']->childs as $value) {
    $i++;
    echo str_replace('#index#', $i, $value->str);
}
?>