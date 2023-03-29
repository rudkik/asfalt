<option value="0" data-id="0">Без договора</option>
<?php
foreach ($data['view::_shop/client/attorney/one/select-option']->childs as $value) {
    echo $value->str;
}
?>
