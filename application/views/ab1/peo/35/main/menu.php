<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopcar/asu')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopcar/asu">Очередь на погрузку</a></li>
    <li <?php if(strpos($siteData->url, '/shopcar/history')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopcar/history">История реализации</a></li>
    <li <?php if(strpos($siteData->url, '/shoppiece/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shoppiece/index">История ЖБИ и БС</a></li>
    <li <?php if(strpos($siteData->url, '/shopmovecar/history')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopmovecar/history">История перемещения</a></li>
    <li <?php if(strpos($siteData->url, '/shopdefectcar/history')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopdefectcar/history">Возмещение брака</a></li>
    <li <?php if(strpos($siteData->url, '/shopcartomaterial/') && strpos($siteData->url, '/shopcartomaterial/statistics') === false){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopcartomaterial/index">Машины с материалом</a></li>

    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Акты сверки <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopactreviseitem/client')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopactreviseitem/client">Акт сверки клиента</a></li>
            <li <?php if(strpos($siteData->url, '/shopactreviseitem/virtual')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopactreviseitem/virtual">Баланс клиента</a></li>
        </ul>
    </li>

    <li <?php if(strpos($siteData->url, '/shopclientguarantee/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopclientguarantee/index">Гарантийные письма</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Сводная <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(((strpos($siteData->url, '/shopproductrubric/statistics')) || (strpos($siteData->url, '/shopproduct/statistics'))) && (Request_RequestParams::getParamInt('shop_client_id') === NULL)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopproductrubric/statistics">Реализация</a></li>
            <li <?php if((strpos($siteData->url, '/shopclient/statistics'))
                || (strpos($siteData->url, '/shopboxcar/') === false && Request_RequestParams::getParamBoolean('is_charity') !== true && (Request_RequestParams::getParamInt('shop_client_id') !== NULL) && strpos($siteData->url, '/shopclient/charity_statistics') === false)
                && (!((strpos($siteData->url, '/shopmovecar/')) || (strpos($siteData->url, '/shopmoveclient/'))))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopclient/statistics">Реализация по клиентам</a></li>
            <li <?php if((strpos($siteData->url, '/shopstorage/')) || (strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopstorage/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Склад</a></li>
            <li <?php if((strpos($siteData->url, '/shopdelivery/')) || (strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopdelivery/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Доставка</a></li>
            <li <?php if((strpos($siteData->url, '/shopmovecar/')) || (strpos($siteData->url, '/shopmoveclient/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopmovecar/statistics">Перемещение</a></li>
            <li <?php if(Request_RequestParams::getParamBoolean('is_charity') === true || strpos($siteData->url, '/shopclient/charity_statistics')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopclient/charity_statistics">Благотворительность</a></li>
            <li <?php if(Request_RequestParams::getParamBoolean('is_import_car') && (strpos($siteData->url, '/shopcartomaterial/') || strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopcartomaterial/statistics?shop_branch_id=<?php echo $siteData->shopID;?>&is_import_car=1">Завоз материалов</a></li>
            <li <?php if(!Request_RequestParams::getParamBoolean('is_import_car') && (strpos($siteData->url, '/shopcartomaterial/statistics') || strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopcartomaterial/statistics?shop_branch_id=<?php echo $siteData->shopID;?>&is_import_car=0">Перемещение материалов</a></li>
            <li <?php if(Request_RequestParams::getParamInt('shop_client_id') === NULL && strpos($siteData->url, '/shopboxcar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopboxcar/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Приём вагонов</a></li>
            <li <?php if(strpos($siteData->url, '/shopballast/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopballast/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Балласт</a></li>
            <li <?php if((Request_RequestParams::getParamInt('shop_client_id') > 0 && strpos($siteData->url, '/shopboxcar/index')) || (strpos($siteData->url, '/shoplesseecar/')) || strpos($siteData->url, '/shoplesseecar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shoplesseecar/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Ответ.хранение</a></li>
            <li <?php if(strpos($siteData->url, '/shoptransport/') || strpos($siteData->url, '/shoptransportwaybill/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shoptransport/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Транспорт</a></li>
            <li <?php if(strpos($siteData->url, '/fuel/') || strpos($siteData->url, '/shoptransportwaybill/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/fuel/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">ГСМ</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> АТЦ <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shoptransportwaybill/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shoptransportwaybill/index">Путевой лист</a></li>
            <li <?php if(strpos($siteData->url, '/shoptransportwaybillcar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shoptransportwaybillcar/index">Анализ начисления</a></li>
            <li <?php if(strpos($siteData->url, '/shoptransportrepair/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shoptransportrepair/index">Анализ ремонтов</a></li>
            <li <?php if(strpos($siteData->url, '/shoptransportwaybillworkdriver/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shoptransportwaybillworkdriver/index">Анализ выработок</a></li>
            <li <?php if(strpos($siteData->url, '/shoptransportwaybillworkdriver/work')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shoptransportwaybillworkdriver/work">Анализ выработок видов работ транспорта</a></li>
            <li <?php if(strpos($siteData->url, '/shoptransportroute/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shoptransportroute/index">Маршруты</a></li>
            <li <?php if(strpos($siteData->url, '/shoptransportwork/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shoptransportwork/index">Параметры выработки</a></li>
            <li <?php if(strpos($siteData->url, '/shoptransportindicator/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shoptransportindicator/index">Показатели расчета</a></li>
            <li <?php if(strpos($siteData->url, '/shoptransportindicatorformula/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shoptransportindicatorformula/index">Формула показатели расчета</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shopxml/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopxml/index">Загрузка c 1C</a></li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopworkerentryexit/history">КПП</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopreport/index">Отчеты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopballastdistance/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopballastdistance/index?is_public_ignore=1">Места погрузки балласта</a></li>
            <li <?php if(strpos($siteData->url, '/shopproduct/pricelist')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopproduct/pricelist?is_public_ignore=1">Печать прайс-листов</a></li>
            <li <?php if(strpos($siteData->url, '/shopproductturnplace/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopproductturnplace/index?is_public_ignore=1">Нормы заработной платы АСУ</a></li>
            <li <?php if(strpos($siteData->url, '/holiday')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/holidayyear/index?is_public_ignore=1">Праздничные и выходные дни</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/peo/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>