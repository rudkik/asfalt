<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <?php if(Request_RequestParams::getParamBoolean('is_all')){?>
            <th style="width: 91px;">№ талона</th>
            <th style="width: 150px;">Талон клиента</th>
            <th style="width: 91px;">№ машины</th>
        <?php }?>
        <th>Продукция</th>
        <th class="text-right width-150">Цена</th>
        <th class="text-right width-80">Кол-во</th>
        <th class="text-right width-120">Сумма</th>
        <?php if(!$isShow){ ?>
        <th style="width: 193px;"></th>
        <?php } ?>
    </tr>
    <tbody id="products">
    <?php
    foreach ($data['view::_shop/invoice/item/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>

