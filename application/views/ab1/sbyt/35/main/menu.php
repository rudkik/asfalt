<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shoppayment/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shoppayment/index">Счета</a></li>
    <li <?php if(strpos($siteData->url, '/shopclientchangemoneytype/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopclientchangemoneytype/index">Перенос баланса</a></li>
    <li <?php if(strpos($siteData->url, '/shoppiece/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shoppiece/index">ЖБИ и БС</a></li>
    <li <?php if(strpos($siteData->url, '/shopcar/') && strpos($siteData->url, '/shopcar/asu') === false){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopcar/history">История реализации</a></li>
    <li <?php if(strpos($siteData->url, '/shopmovecar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopmovecar/history">История перемещения</a></li>
    <li <?php if(strpos($siteData->url, '/shopdefectcar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopdefectcar/history">Возмещение брака</a></li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopworkerentryexit/history">КПП</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopreport/index">Отчеты</a></li>
    <li <?php if(strpos($siteData->url, '/shoppricelist/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shoppricelist/index">Скидки</a></li>
    <li <?php if(strpos($siteData->url, '/shopdeliverydiscount/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopdeliverydiscount/index">Скидка на доставку</a></li>
    <li <?php if(strpos($siteData->url, '/shopclient/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopclient/index">Клиенты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Закрывающие документы <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopinvoice/virtual')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopinvoice/virtual_index">Новые накладные</a></li>
            <li <?php if((strpos($siteData->url, '/shopinvoice/')) && (strpos($siteData->url, '/shopinvoice/virtual') === FALSE)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopinvoice/index">Сформированные накладные</a></li>
            <li <?php if(strpos($siteData->url, '/shopactservice/virtual')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopactservice/virtual_index">Новые акты</a></li>
            <li <?php if((strpos($siteData->url, '/shopactservice/')) && (strpos($siteData->url, '/shopactservice/virtual') === FALSE)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopactservice/index">Проверенные акты</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shopclient/client')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopclient/client">Дебиторы и кредиторы</a></li>
    <li <?php if(strpos($siteData->url, '/shopactreviseitem/client')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopactreviseitem/client">Акт сверки клиента</a></li>
    <li <?php if(strpos($siteData->url, '/shopinvoiceproforma/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopinvoiceproforma/index">Счет на оплату</a></li>
    <li <?php if(strpos($siteData->url, '/shopclientattorney/') && strpos($siteData->url, '/shopclientattorney/control') === false){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopclientattorney/index">Доверенности</a></li>
    <li <?php if(strpos($siteData->url, '/shopclientattorney/control')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopclientattorney/control">Контроль</a></li>
    <li <?php if(strpos($siteData->url, '/shopclientcontract/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopclientcontract/index?is_public_ignore=1">Договоры</a></li>
    <li <?php if(strpos($siteData->url, '/shopclientguarantee/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopclientguarantee/index">Гарантийные письма</a></li>
    <li <?php if(strpos($siteData->url, '/shopcar/asu')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopcar/asu">Машины на погрузку</a></li>
    <li <?php if(strpos($siteData->url, '/shopxml/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopxml/index">Выгрузка в 1С</a></li>
    <li <?php if(strpos($siteData->url, '/shopproduct/pricelist')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopproduct/pricelist?is_public_ignore=1">Печать прайс-листов</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopclientbalanceday/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopclientbalanceday/index?is_public_ignore=1">Фиксированные балансы клиентов</a></li>
            <li <?php if(strpos($siteData->url, '/shopactreviseitem/virtual')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopactreviseitem/virtual">Расшифровка баланса клиента</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopdeliverydepartment/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopdeliverydepartment/index?is_public_ignore=1">Цеха доставки</a></li>
                <li <?php if(strpos($siteData->url, '/shopdeliverygroup/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopdeliverygroup/index?is_public_ignore=1">Группы продукции</a></li>
                <li <?php if(strpos($siteData->url, '/shopactreviseitem/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopactreviseitem/index">Данные из 1С</a></li>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>