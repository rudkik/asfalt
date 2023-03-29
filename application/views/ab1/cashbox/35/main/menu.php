<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shoppayment/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cashbox/shoppayment/index">ПКО</a></li>
    <li <?php if(strpos($siteData->url, '/shopinvoiceproforma/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cashbox/shopinvoiceproforma/index">Счета на оплату</a></li>
    <li <?php if(strpos($siteData->url, '/shoppaymentreturn/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cashbox/shoppaymentreturn/index">Возврат</a></li>
    <li <?php if(strpos($siteData->url, '/shopconsumable/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cashbox/shopconsumable/index">Расходники</a></li>
    <li <?php if(strpos($siteData->url, '/shopcomingmoney/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cashbox/shopcomingmoney/index">Приходник</a></li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cashbox/shopworkerentryexit/history">КПП</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cashbox/shopreport/index">Отчеты</a></li>
    <li <?php if(strpos($siteData->url, '/shopfinish/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cashbox/shopfinish/index">Конец дня</a></li>
    <li <?php if(strpos($siteData->url, '/shopactreviseitem/edit_contract')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cashbox/shopactreviseitem/edit_contract">Приходники из 1С</a></li>
    <li <?php if(strpos($siteData->url, '/shopxml/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cashbox/shopxml/index">Загрузка c 1C</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopclient/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cashbox/shopclient/index?is_public_ignore=1">Клиенты</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cashbox/shopoperation/index?is_public_ignore=1">Операторы</a></li>
                <li <?php if(strpos($siteData->url, '/shopcashbox/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cashbox/shopcashbox/index?is_public_ignore=1">Фискальные регистраторы</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>