<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopcar/asu')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopcar/asu">Очередь на погрузку</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Сводная <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(((strpos($siteData->url, '/shopproductrubric/statistics')) || (strpos($siteData->url, '/shopproduct/statistics'))) && (Request_RequestParams::getParamInt('shop_client_id') === NULL)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopproductrubric/statistics">Реализация</a></li>
            <li <?php if((strpos($siteData->url, '/shopclient/statistics'))
                || (strpos($siteData->url, '/shopboxcar/') === false && Request_RequestParams::getParamBoolean('is_charity') !== true && (Request_RequestParams::getParamInt('shop_client_id') !== NULL) && strpos($siteData->url, '/shopclient/charity_statistics') === false)
                && (!((strpos($siteData->url, '/shopmovecar/')) || (strpos($siteData->url, '/shopmoveclient/'))))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopclient/statistics">Реализация по клиентам</a></li>
            <li <?php if((strpos($siteData->url, '/shopclient/compensation/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopclient/compensation">Возмещение клиентам</a></li>
            <li <?php if((strpos($siteData->url, '/shopstorage/')) || (strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopstorage/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Склад</a></li>
            <li <?php if((strpos($siteData->url, '/shopdelivery/')) || (strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopdelivery/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Доставка</a></li>
            <li <?php if((strpos($siteData->url, '/shopmovecar/')) || (strpos($siteData->url, '/shopmoveclient/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopmovecar/statistics">Перемещение</a></li>
            <li <?php if(Request_RequestParams::getParamBoolean('is_charity') === true || strpos($siteData->url, '/shopclient/charity_statistics')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopclient/charity_statistics">Благотворительность</a></li>
            <li <?php if(Request_RequestParams::getParamBoolean('is_import_car') && (strpos($siteData->url, '/shopcartomaterial/') || strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopcartomaterial/statistics?shop_branch_id=<?php echo $siteData->shopID;?>&is_import_car=1">Завоз материалов</a></li>
            <li <?php if(!Request_RequestParams::getParamBoolean('is_import_car') && (strpos($siteData->url, '/shopcartomaterial/statistics') || strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopcartomaterial/statistics?shop_branch_id=<?php echo $siteData->shopID;?>&is_import_car=0">Перемещение материалов</a></li>
            <li <?php if(Request_RequestParams::getParamInt('shop_client_id') === NULL && strpos($siteData->url, '/shopboxcar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopboxcar/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Приём вагонов</a></li>
            <li <?php if(strpos($siteData->url, '/shopballast/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopballast/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Балласт</a></li>
            <li <?php if((Request_RequestParams::getParamInt('shop_client_id') > 0 && strpos($siteData->url, '/shopboxcar/index')) || (strpos($siteData->url, '/shoplesseecar/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shoplesseecar/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Ответ.хранение</a></li>
            <li <?php if(strpos($siteData->url, '/shopclientcontract/director')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopclientcontract/director?shop_branch_id=<?php echo $siteData->shopID;?>">Договоры</a></li>
            <li <?php if(strpos($siteData->url, '/shoptransport/') || strpos($siteData->url, '/shoptransportwaybill/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shoptransport/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Транспорт</a></li>
            <li <?php if(strpos($siteData->url, '/fuel/') || strpos($siteData->url, '/shoptransportwaybill/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/fuel/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">ГСМ</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shoppaymentschedule/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shoppaymentschedule/index">Планируемые оплаты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Счета <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shoppayment/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shoppayment/index">Счета</a></li>
            <li <?php if(strpos($siteData->url, '/shopinvoiceproforma/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopinvoiceproforma/index">Счета на оплату</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">По продукции <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopcar/history')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopcar/history">История реализации</a></li>
            <li <?php if(strpos($siteData->url, '/shoppiece/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shoppiece/index">История ЖБИ и БС</a></li>
            <li <?php if(strpos($siteData->url, '/shopmovecar/history')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopmovecar/history">История перемещения</a></li>
            <li <?php if(strpos($siteData->url, '/shopdefectcar/history')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopdefectcar/history">Возмещение брака</a></li>
            <li <?php if(strpos($siteData->url, '/shopproductstorage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopproductstorage/index">Продукция на склад</a></li>
        </ul>
    </li>

    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">По материалу <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if((strpos($siteData->url, '/shopregistermaterial/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopregistermaterial/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Остатки материалов (разработка)</a></li>
            <li <?php if(strpos($siteData->url, '/shopcartomaterial/') && Request_RequestParams::getParamBoolean('is_weighted')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopcartomaterial/index?is_weighted=1">Машины с материалом</a></li>
            <li <?php if(strpos($siteData->url, '/shopcartomaterial/') && !Request_RequestParams::getParamBoolean('is_weighted')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopcartomaterial/index?is_weighted=0">Добавки</a></li>
        </ul>
    </li>

    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">По клиенту <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopclientcontract/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopclientcontract/index?is_public_ignore=1&client_contract_status_id=1">Договоры</a></li>
            <li <?php if(strpos($siteData->url, '/shopclientguarantee/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopclientguarantee/index">Гарантийные письма</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Акты сверки <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopactreviseitem/virtual')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopactreviseitem/virtual">Расшифровка баланса клиента</a></li>
            <li <?php if(strpos($siteData->url, '/shopactreviseitem/client')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopactreviseitem/client">Акт сверки клиента</a></li>
            <li <?php if(strpos($siteData->url, '/shopactreviseitem/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopactreviseitem/index">Данные из 1С</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shopproduct/pricelist')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopproduct/pricelist?shop_branch_id=<?php echo $siteData->shopID;?>">Прайс-лист</a></li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopworkerentryexit/history">КПП</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopreport/index">Отчеты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> НБЦ <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopmaterialstorage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopmaterialstorage/total">Остатки готовой продукции</a></li>
            <li <?php if(strpos($siteData->url, '/shoprawstorage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shoprawstorage/total">Остатки сырьевой парк</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopclient/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopclient/index?is_public_ignore=1">Клиенты</a></li>
            <li <?php if(strpos($siteData->url, '/shopmoveclient/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopmoveclient/index?is_public_ignore=1">Подразделения</a></li>
            <li <?php if(strpos($siteData->url, '/shopproduct/pricelist')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopproduct/pricelist_print?is_public_ignore=1">Печать прайс-листов</a></li>
            <li <?php if(strpos($siteData->url, '/shopproduct/') && strpos($siteData->url, '/shopproduct/pricelist') === false){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopproduct/index?is_public_ignore=1">Продукты</a></li>
            <li <?php if(strpos($siteData->url, '/shopproductrubric/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopproductrubric/index?is_public_ignore=1">Рубрики продукции</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>