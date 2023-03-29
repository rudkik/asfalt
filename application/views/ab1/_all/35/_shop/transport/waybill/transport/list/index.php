<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>Транспортное средство</th>
        <th class="text-right">Пробег</th>
    </tr>
    <tbody id="transports">
    <?php
    foreach ($data['view::_shop/transport/waybill/transport/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<?php if(!$isShow){ ?>
<div id="new-transport" data-index="0">
    <!--
    <tr data-id="#index#">
        <td data-id="name"></td>
        <td class="text-right" data-id="milage"></td>
    </tr>
    -->
</div>
<?php } ?>