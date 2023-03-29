<option value="0" data-id="0">Выберите значение</option>
<?php
foreach ($data['view::_shop/storage/one/select-option']->childs as $value) {
    echo $value->str;
}
?>
