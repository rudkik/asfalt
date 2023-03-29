<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopcar/ttn')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopcar/ttn">ТТН</a></li>
    <li <?php if(strpos($siteData->url, '/shoppricelist/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shoppricelist/index">Скидки</a></li>
    <li <?php if(strpos($siteData->url, '/shopclient/') && strpos($siteData->url, '/shopclient/statistics') === false){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopclient/index">Клиенты</a></li>
    <li <?php if((strpos($siteData->url, '/shopinvoice/')) && (strpos($siteData->url, '/shopinvoice/virtual') === FALSE)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopinvoice/index">Сформированные накладные</a></li>
    <li <?php if((strpos($siteData->url, '/shopactservice/')) && (strpos($siteData->url, '/shopactservice/virtual') === FALSE)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopactservice/index">Проверенные акты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Акты сверки <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopactreviseitem/virtual')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopactreviseitem/virtual">Расшифровка баланса клиента</a></li>
            <li <?php if(strpos($siteData->url, '/shopactreviseitem/client')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopactreviseitem/client">Акт сверки клиента</a></li>
            <li <?php if(strpos($siteData->url, '/shopactreviseitem/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopactreviseitem/index">Данные из 1С</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shopclientattorney/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopclientattorney/index?is_public_ignore=1">Доверенности</a></li>
    <li <?php if(strpos($siteData->url, '/shopclientcontract/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopclientcontract/index?client_contract_status_id=1">Договоры</a></li>
    <li <?php if(strpos($siteData->url, '/shopproductstorage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopproductstorage/index">Продукция на склад</a></li>

    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Сводная <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(((strpos($siteData->url, '/shopproductrubric/statistics')) || (strpos($siteData->url, '/shopproduct/statistics'))) && (Request_RequestParams::getParamInt('shop_client_id') === NULL)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopproductrubric/statistics">Реализация</a></li>
            <li <?php if((strpos($siteData->url, '/shopclient/statistics'))
                || (strpos($siteData->url, '/shopboxcar/') === false && Request_RequestParams::getParamBoolean('is_charity') !== true && (Request_RequestParams::getParamInt('shop_client_id') !== NULL) && strpos($siteData->url, '/shopclient/charity_statistics') === false)
                && (!((strpos($siteData->url, '/shopmovecar/')) || (strpos($siteData->url, '/shopmoveclient/'))))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopclient/statistics">Реализация по клиентам</a></li>
            <li <?php if((strpos($siteData->url, '/shopstorage/')) || (strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopstorage/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Склад</a></li>
            <li <?php if((strpos($siteData->url, '/shopdelivery/')) || (strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopdelivery/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Доставка</a></li>
            <li <?php if((strpos($siteData->url, '/shopmovecar/')) || (strpos($siteData->url, '/shopmoveclient/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopmovecar/statistics">Перемещение</a></li>
            <li <?php if(Request_RequestParams::getParamBoolean('is_charity') === true || strpos($siteData->url, '/shopclient/charity_statistics')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopclient/charity_statistics">Благотворительность</a></li>
            <li <?php if(Request_RequestParams::getParamBoolean('is_import_car') && (strpos($siteData->url, '/shopcartomaterial/') || strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopcartomaterial/statistics?shop_branch_id=<?php echo $siteData->shopID;?>&is_import_car=1">Завоз материалов</a></li>
            <li <?php if(!Request_RequestParams::getParamBoolean('is_import_car') && (strpos($siteData->url, '/shopcartomaterial/statistics') || strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopcartomaterial/statistics?shop_branch_id=<?php echo $siteData->shopID;?>&is_import_car=0">Перемещение материалов</a></li>
            <li <?php if(strpos($siteData->url, '/shopboxcar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopboxcar/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Приём вагонов</a></li>
            <li <?php if(strpos($siteData->url, '/shopballast/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopballast/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Балласт</a></li>
            <li <?php if((Request_RequestParams::getParamInt('shop_client_id') > 0 && strpos($siteData->url, '/shopboxcar/index')) || strpos($siteData->url, '/shoplesseecar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shoplesseecar/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Ответ.хранение</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopworkerentryexit/history">КПП</a></li>
    <?php if($siteData->operation->getIsAdmin()){ ?>
    <li <?php if(strpos($siteData->url, '/shopclientguarantee/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopclientguarantee/index">Гарантийные письма</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopreport/index">Отчеты</a></li>
    <?php if($siteData->operation->getIsAdmin()){ ?>
        <li role="presentation" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
            <ul class="dropdown-menu">
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/general/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            </ul>
        </li>
    <?php } ?>
    <?php } ?>
</ul>