<option value="0" data-id="0">Без гарантийного письма</option>
<?php
foreach ($data['view::_shop/client/guarantee/one/select-option']->childs as $value) {
    echo $value->str;
}
?>
