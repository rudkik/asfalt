<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-110">Дата начала</th>
        <th class="width-110">Дата окончания</th>
        <th class="width-105">Цена</th>
    </tr>
    <tbody id="products">
    <?php
    foreach ($data['view::_shop/product/time/price/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>