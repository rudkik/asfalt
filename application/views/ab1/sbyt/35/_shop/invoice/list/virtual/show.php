<?php $isAll = Request_RequestParams::getParamBoolean('is_all');?>
<table class="table table-hover table-db table-tr-line" >
    <tr>
        <?php $isAll = Request_RequestParams::getParamBoolean('is_all'); if($isAll){?>
            <th style="width: 87px;">Проверено</th>
            <th style="width: 91px;">№ талона</th>
            <th style="width: 150px;">Талон клиента</th>
            <th style="width: 91px;">№ машины</th>
        <?php }?>
        <th>Продукция</th>
        <?php if(!$isAll){?>
            <th class="text-right width-120">Кол-во талонов</th>
        <?php }?>
        <th class="text-right width-150">Цена</th>
        <th class="text-right width-100">Кол-во</th>
        <th class="text-right width-120">Сумма</th>
        <th style="width: 193px;"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/invoice/one/virtual/show']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>

