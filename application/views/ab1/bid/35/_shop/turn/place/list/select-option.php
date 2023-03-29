<option value="-1" data-id="-1">Выберите значение</option>
<?php
foreach ($data['view::_shop/turn/place/one/select-option']->childs as $value) {
    echo $value->str;
}
?>
