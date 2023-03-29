<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopclientcontract/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/jurist/shopclientcontract/index">Договоры</a></li>
    <li <?php if(strpos($siteData->url, '/shopclient/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/jurist/shopclient/index">Клиенты</a></li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/jurist/shopworkerentryexit/history">КПП</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopclientcontractstorage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/jurist/shopclientcontractstorage/index?is_public_ignore=1">Места хранения договоров</a></li>
            <li <?php if(strpos($siteData->url, '/clientcontractstatus/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/jurist/clientcontractstatus/index?is_public_ignore=1">Статусы договоров</a></li>
            <li <?php if(strpos($siteData->url, '/clientcontracttype/template')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/jurist/clientcontracttype/template?is_public_ignore=1">Шаблоны договоров</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/clientcontractview/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/jurist/clientcontractview/index?is_public_ignore=1">Типы договоров</a></li>
                <li <?php if(strpos($siteData->url, '/clientcontracttype/template') === false && strpos($siteData->url, '/clientcontracttype/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/jurist/clientcontracttype/index?is_public_ignore=1">Категории договоров</a></li>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/jurist/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>