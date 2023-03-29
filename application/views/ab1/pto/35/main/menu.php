<ul class="nav nav-tabs">
    <?php if($siteData->operation->getShopTableUnitID()){ ?>
        <li <?php if(strpos($siteData->url, '/shoppayment/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shoppayment/index">Счета</a></li>
        <li <?php if(strpos($siteData->url, '/shopcar/history')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopcar/history">История реализации</a></li>
        <li <?php if(strpos($siteData->url, '/shoppiece/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shoppiece/index">История ЖБИ и БС</a></li>
        <li <?php if(strpos($siteData->url, '/shopmovecar/history')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopmovecar/history">История перемещения</a></li>
        <li <?php if(strpos($siteData->url, '/shopdefectcar/history')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopdefectcar/history">Возмещение брака</a></li>
        <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopreport/index">Отчеты</a></li>
    <?php }else{ ?>
        <li <?php if(strpos($siteData->url, '/shopcar/asu')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopcar/asu">Очередь на погрузку</a></li>
        <li role="presentation" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Сводная <span class="caret"></span> </a>
            <ul class="dropdown-menu">
                <li <?php if(((strpos($siteData->url, '/shopproductrubric/statistics')) || (strpos($siteData->url, '/shopproduct/statistics'))) && (Request_RequestParams::getParamInt('shop_client_id') === NULL)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopproductrubric/statistics">Реализация</a></li>
                <li <?php if((strpos($siteData->url, '/shopclient/statistics'))
                    || (strpos($siteData->url, '/shopboxcar/') === false && Request_RequestParams::getParamBoolean('is_charity') !== true && (Request_RequestParams::getParamInt('shop_client_id') !== NULL) && strpos($siteData->url, '/shopclient/charity_statistics') === false)
                    && (!((strpos($siteData->url, '/shopmovecar/')) || (strpos($siteData->url, '/shopmoveclient/'))))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopclient/statistics">Реализация по клиентам</a></li>
                <li <?php if((strpos($siteData->url, '/shopstorage/')) || (strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopstorage/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Склад</a></li>
                <li <?php if((strpos($siteData->url, '/shopdelivery/')) || (strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopdelivery/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Доставка</a></li>
                <li <?php if((strpos($siteData->url, '/shopmovecar/')) || (strpos($siteData->url, '/shopmoveclient/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopmovecar/statistics">Перемещение</a></li>
                <li <?php if(Request_RequestParams::getParamBoolean('is_charity') === true || strpos($siteData->url, '/shopclient/charity_statistics')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopclient/charity_statistics">Благотворительность</a></li>
                <li <?php if(Request_RequestParams::getParamBoolean('is_import_car') && (strpos($siteData->url, '/shopcartomaterial/') || strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopcartomaterial/statistics?shop_branch_id=<?php echo $siteData->shopID;?>&is_import_car=1">Завоз материалов</a></li>
                <li <?php if(!Request_RequestParams::getParamBoolean('is_import_car') && (strpos($siteData->url, '/shopcartomaterial/statistics') || strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopcartomaterial/statistics?shop_branch_id=<?php echo $siteData->shopID;?>&is_import_car=0">Перемещение материалов</a></li>
                <li <?php if(Request_RequestParams::getParamInt('shop_client_id') === NULL && strpos($siteData->url, '/shopboxcar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopboxcar/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Приём вагонов</a></li>
                <li <?php if(strpos($siteData->url, '/shopballast/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopballast/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Балласт</a></li>
                <li <?php if((Request_RequestParams::getParamInt('shop_client_id') > 0 && strpos($siteData->url, '/shopboxcar/index')) || (strpos($siteData->url, '/shoplesseecar/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shoplesseecar/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Ответ.хранение</a></li>
            </ul>
        </li>
        <li <?php if(strpos($siteData->url, '/shoppaymentschedule/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shoppaymentschedule/index">Планируемые оплаты</a></li>
        <li role="presentation" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Счета <span class="caret"></span> </a>
            <ul class="dropdown-menu">
                <li <?php if(strpos($siteData->url, '/shoppayment/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shoppayment/index">Счета</a></li>
                <li <?php if(strpos($siteData->url, '/shopinvoiceproforma/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopinvoiceproforma/index">Счета на оплату</a></li>
            </ul>
        </li>
        <li <?php if(strpos($siteData->url, '/shopcar/history')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopcar/history">История реализации</a></li>
        <li <?php if(strpos($siteData->url, '/shoppiece/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shoppiece/index">История ЖБИ и БС</a></li>
        <li <?php if(strpos($siteData->url, '/shopmovecar/history')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopmovecar/history">История перемещения</a></li>
        <li <?php if(strpos($siteData->url, '/shopcartomaterial/') && strpos($siteData->url, '/shopcartomaterial/statistics') === false){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopcartomaterial/index">Машины с материалом</a></li>

        <li role="presentation" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Договоры <span class="caret"></span> </a>
            <ul class="dropdown-menu">
                <li <?php if(Request_RequestParams::getParamInt('client_contract_type_id') == null && strpos($siteData->url, '/shopclientcontract/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopclientcontract/index?is_public_ignore=1&client_contract_status_id=1">Договоры</a></li>
                <li <?php if(Request_RequestParams::getParamInt('client_contract_type_id') == Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_MATERIAL && strpos($siteData->url, '/shopclientcontract/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopclientcontract/index?is_public_ignore=1&client_contract_type_id=<?php echo Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_MATERIAL; ?>&client_contract_status_id=1">Договоры материалов</a></li>
                <li <?php if(Request_RequestParams::getParamInt('client_contract_type_id') == Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_RAW && strpos($siteData->url, '/shopclientcontract/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopclientcontract/index?is_public_ignore=1&client_contract_type_id=<?php echo Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_RAW; ?>&client_contract_status_id=1">Договоры сырья</a></li>
                <li <?php if(Request_RequestParams::getParamInt('client_contract_type_id') == Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_PRODUCT_SHOP && strpos($siteData->url, '/shopclientcontract/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopclientcontract/index?is_public_ignore=1&client_contract_type_id=<?php echo Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_PRODUCT_SHOP; ?>&client_contract_status_id=1">Договоры закуп продуктов питания</a></li>
            </ul>
        </li>
        <li <?php if(strpos($siteData->url, '/shopclientguarantee/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopclientguarantee/index">Гарантийные письма</a></li>

        <li role="presentation" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Акты сверки <span class="caret"></span> </a>
            <ul class="dropdown-menu">
                <li <?php if(strpos($siteData->url, '/shopactreviseitem/virtual')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopactreviseitem/virtual">Расшифровка баланса клиента</a></li>
                <li <?php if(strpos($siteData->url, '/shopactreviseitem/client')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopactreviseitem/client">Акт сверки клиента</a></li>
                <li <?php if(strpos($siteData->url, '/shopactreviseitem/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopactreviseitem/index">Данные из 1С</a></li>
            </ul>
        </li>
        <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopworkerentryexit/history">КПП</a></li>
        <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopreport/index">Отчеты</a></li>
        <li role="presentation" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
            <ul class="dropdown-menu">
                <li <?php if(strpos($siteData->url, '/shopclient/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopclient/index?is_public_ignore=1">Клиенты</a></li>
                <li <?php if(strpos($siteData->url, '/shopmoveclient/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopmoveclient/index?is_public_ignore=1">Подразделения</a></li>
                <li <?php if(strpos($siteData->url, '/shopproduct/pricelist')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopproduct/pricelist?is_public_ignore=1">Печать прайс-листов</a></li>
                <li <?php if(strpos($siteData->url, '/shopproduct/') && strpos($siteData->url, '/shopproduct/pricelist') === false){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopproduct/index?is_public_ignore=1">Продукты</a></li>
                <li <?php if(strpos($siteData->url, '/shopproductrubric/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopproductrubric/index?is_public_ignore=1">Рубрики продукции</a></li>
                <li <?php if(strpos($siteData->url, '/shopmaterial/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopmaterial/index?is_public_ignore=1">Материалы</a></li>
                <li <?php if(strpos($siteData->url, '/shopmaterialother/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopmaterialother/index?is_public_ignore=1">Прочие материалы</a></li>
                <?php if($siteData->operation->getIsAdmin()){ ?>
                    <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/pto/shopoperation/index?is_public_ignore=1">Операторы</a></li>
                <?php } ?>
            </ul>
        </li>
    <?php } ?>
</ul>