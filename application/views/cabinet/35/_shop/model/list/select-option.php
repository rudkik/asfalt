<option data-id="0" value="0">Без значения</option>
<?php
foreach ($data['view::_shop/model/one/select-option']->childs as $value) {
    echo $value->str;
}
?>