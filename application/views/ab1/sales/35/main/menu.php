<ul class="nav nav-tabs">
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> История <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shoppayment/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shoppayment/index">Счета</a></li>
            <li <?php if(strpos($siteData->url, '/shoppiece/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shoppiece/index">ЖБИ и БС</a></li>
            <li <?php if(strpos($siteData->url, '/shopcar/') && strpos($siteData->url, '/shopcar/asu') === false){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopcar/history">История реализации</a></li>
            <li <?php if(strpos($siteData->url, '/shopmovecar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopmovecar/history">История перемещения</a></li>
            <li <?php if(strpos($siteData->url, '/shopdefectcar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopdefectcar/history">Возмещение брака</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopreport/index">Отчеты</a></li>
    <li <?php if(strpos($siteData->url, '/shoppricelist/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shoppricelist/index">Скидки</a></li>
    <li <?php if(strpos($siteData->url, '/shopclient/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopclient/index">Клиенты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Закрывающие документы <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopinvoice/virtual')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopinvoice/virtual_index">Новые накладные</a></li>
            <li <?php if((strpos($siteData->url, '/shopinvoice/')) && (strpos($siteData->url, '/shopinvoice/virtual') === FALSE)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopinvoice/index">Сформированные накладные</a></li>
            <li <?php if(strpos($siteData->url, '/shopactservice/virtual')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopactservice/virtual_index">Новые акты</a></li>
            <li <?php if((strpos($siteData->url, '/shopactservice/')) && (strpos($siteData->url, '/shopactservice/virtual') === FALSE)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopactservice/index">Проверенные акты</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shopactreviseitem/client')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopactreviseitem/client">Акт сверки клиента</a></li>
    <li <?php if(strpos($siteData->url, '/shopinvoiceproforma/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopinvoiceproforma/index">Счет на оплату</a></li>
    <li <?php if(strpos($siteData->url, '/shopclientattorney/') && strpos($siteData->url, '/shopclientattorney/control') === false){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopclientattorney/index">Доверенности</a></li>
    <li <?php if(strpos($siteData->url, '/shopclientattorney/control')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopclientattorney/control">Контроль</a></li>
    <li <?php if(strpos($siteData->url, '/shopclientcontract/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopclientcontract/index?is_public_ignore=1">Договоры</a></li>
    <li <?php if(strpos($siteData->url, '/shopclientguarantee/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopclientguarantee/index">Гарантийные письма</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Очередь <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopcar/territory')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopcar/territory">Машины на территории</a></li>
            <li <?php if(strpos($siteData->url, '/shopcar/asu')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopcar/asu?shop_branch_id=<?php echo $siteData->shopID;?>">Очередь на погрузку</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Заявки <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopplan/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopplan/index">Заявки</a></li>
            <li <?php if(strpos($siteData->url, '/shopplantransport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopplantransport/index">Вывод спецтранспорта</a></li>
            <li <?php if(strpos($siteData->url, '/shopplanitem/reason')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopplanitem/reason">Заявки причины</a></li>
            <li <?php if(strpos($siteData->url, '/shopbid/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopbid/index">Заявки на месяц</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Цены <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopcompetitorprice/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopcompetitorprice/index">Цены конкурентов</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shopxml/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopxml/index">Выгрузка в 1С</a></li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopworkerentryexit/history">КПП</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopclientbalanceday/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopclientbalanceday/index?is_public_ignore=1">Фиксированные балансы клиентов</a></li>
            <li <?php if(strpos($siteData->url, '/shopproduct/pricelist')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopproduct/pricelist?is_public_ignore=1">Печать прайс-листов</a></li>
            <li <?php if(strpos($siteData->url, '/shopspecialtransport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopspecialtransport/index?is_public_ignore=1">Спецтранспорт</a></li>
            <li <?php if(strpos($siteData->url, '/shopcompetitor/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopcompetitor/index?is_public_ignore=1">Конкуренты</a></li>
            <li <?php if(strpos($siteData->url, '/shopclient/client')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopclient/client">Дебиторы и кредиторы</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopactreviseitem/virtual')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopactreviseitem/virtual">Расшифровка баланса клиента</a></li>
                <li <?php if(strpos($siteData->url, '/shopactreviseitem/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopactreviseitem/index">Данные из 1С</a></li>
                <li <?php if(strpos($siteData->url, '/shopproductgroup/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopproductgroup/index?is_public_ignore=1">Группы продукции</a></li>
                <li <?php if(strpos($siteData->url, '/shopdeliverydepartment/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopdeliverydepartment/index?is_public_ignore=1">Цеха доставки</a></li>
                <li <?php if(strpos($siteData->url, '/shopdeliverygroup/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopdeliverygroup/index?is_public_ignore=1">Группы доставок</a></li>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sales/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>