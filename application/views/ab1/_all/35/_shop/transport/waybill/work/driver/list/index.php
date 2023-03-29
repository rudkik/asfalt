<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>Параметры выработки</th>
        <th>Кол-во</th>
    </tr>
    <tbody id="works">
    <?php
    foreach ($data['view::_shop/transport/waybill/work/driver/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>