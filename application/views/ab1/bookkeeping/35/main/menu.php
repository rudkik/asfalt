<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shoppricelist/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bookkeeping/shoppricelist/index">Скидки</a></li>
    <li <?php if(strpos($siteData->url, '/shopclient/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bookkeeping/shopclient/index">Клиенты</a></li>
    <li <?php if((strpos($siteData->url, '/shopinvoice/')) && (strpos($siteData->url, '/shopinvoice/virtual') === FALSE)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bookkeeping/shopinvoice/index">Сформированные накладные</a></li>
    <li <?php if((strpos($siteData->url, '/shopactservice/')) && (strpos($siteData->url, '/shopactservice/virtual') === FALSE)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bookkeeping/shopactservice/index">Проверенные акты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Акты сверки <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopactreviseitem/virtual')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bookkeeping/shopactreviseitem/virtual">Расшифровка баланса клиента</a></li>
            <li <?php if(strpos($siteData->url, '/shopactreviseitem/client')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bookkeeping/shopactreviseitem/client">Акт сверки клиента</a></li>
            <li <?php if(strpos($siteData->url, '/shopactreviseitem/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bookkeeping/shopactreviseitem/index">Данные из 1С</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shopclientattorney/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bookkeeping/shopclientattorney/index?is_public_ignore=1">Доверенности</a></li>
    <li <?php if(strpos($siteData->url, '/shopclientcontract/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bookkeeping/shopclientcontract/index?client_contract_status_id=1">Договоры</a></li>
    <li <?php if(strpos($siteData->url, '/shopclientguarantee/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bookkeeping/shopclientguarantee/index">Гарантийные письма</a></li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bookkeeping/shopworkerentryexit/history">КПП</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bookkeeping/shopreport/index">Отчеты</a></li>
    <?php if($siteData->operation->getIsAdmin()){ ?>
        <li role="presentation" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
            <ul class="dropdown-menu">
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bookkeeping/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            </ul>
        </li>
    <?php } ?>
</ul>