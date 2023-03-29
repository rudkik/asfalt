<option value="0" data-id="0">
    <?php if(Request_RequestParams::getParamBoolean('is_basic_text')){ ?>
        Исходный договор
    <?php }else{ ?>
        Без договора
    <?php } ?>
</option>
<?php
foreach ($data['view::_shop/client/contract/one/select-option']->childs as $value) {
    echo $value->str;
}
?>
