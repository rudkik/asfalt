<option value="0" data-id="0">Выберите значение</option>
<?php
foreach ($data['view::_shop/heap/one/select-option']->childs as $value) {
    echo $value->str;
}
?>
