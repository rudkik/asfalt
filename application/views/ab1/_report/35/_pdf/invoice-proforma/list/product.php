<?php
$i = 1;
foreach ($data['view::_pdf/invoice-proforma/one/product']->childs as $value) {
    echo str_replace('#index#', $i++, $value->str);
}
?>
