<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientattorney/control'). Func::getAddURLSortBy($siteData->urlParams, 'b.client'); ?>" class="link-black">Клиент</a>
        </th>
        <th class="width-130">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientattorney/control'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">№ доверенности</a>
        </th>
        <th class="width-125">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientattorney/control'). Func::getAddURLSortBy($siteData->urlParams, 'from_at'); ?>" class="link-black">Дата начала</a>
        </th>
        <th class="width-125">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientattorney/control'). Func::getAddURLSortBy($siteData->urlParams, 'to_at'); ?>" class="link-black">Дата окончания</a>
        </th>
        <th class="text-right width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientattorney/control'). Func::getAddURLSortBy($siteData->urlParams, 'balance'); ?>" class="link-black">Остаток доверенности</a>
        </th>
        <th class="text-right width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientattorney/control'). Func::getAddURLSortBy($siteData->urlParams, 'b.client_balance'); ?>" class="link-black">Сумма безналичных</a>
        </th>
        <th class="text-right width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientattorney/control'). Func::getAddURLSortBy($siteData->urlParams, 'b.diff'); ?>" class="link-black">Разница</a>
        </th>
        <th class="text-right width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientattorney/control'). Func::getAddURLSortBy($siteData->urlParams, 'b.balance_cash'); ?>" class="link-black">Сумма наличных</a>
        </th>
        <th class="width-150">
            Кто создал
        </th>
        <th style="width: 193px"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/client/attorney/one/control']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>

