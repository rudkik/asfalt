<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopballast/add')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ballast/shopballast/add">Добавление балласта</a></li>
    <li <?php if(strpos($siteData->url, '/shopballast/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ballast/shopballast/index">Балласт</a></li>
    <li <?php if(strpos($siteData->url, '/shoptransportation/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ballast/shoptransportation/index">Перевозки</a></li>
    <li <?php if(strpos($siteData->url, '/shopballastcartodriver/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ballast/shopballastcartodriver/index?is_public_ignore=1">Машины + водители</a></li>
    <li <?php if(strpos($siteData->url, '/shopballastdriver/statistics')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ballast/shopballastdriver/statistics">Статистика водителей</a></li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ballast/shopworkerentryexit/history">КПП</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ballast/shopreport/index">Отчеты</a></li>
    <?php if($siteData->operation->getIsAdmin()){ ?>
        <li role="presentation" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
            <ul class="dropdown-menu">
                <li <?php if(strpos($siteData->url, '/shopballastdriver/statistics') === false && strpos($siteData->url, '/shopballastdriver/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ballast/shopballastdriver/index?is_public_ignore=1">Водители для перевозки балласта</a></li>
                <li <?php if(strpos($siteData->url, '/shopballastcar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ballast/shopballastcar/index?is_public_ignore=1">Машины для перевозки балласта</a></li>
                <li <?php if(strpos($siteData->url, '/shopballastcrusher/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ballast/shopballastcrusher/index?is_public_ignore=1">Места выгрузки балласта</a></li>
                <li <?php if(strpos($siteData->url, '/shoptransportationplace/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ballast/shoptransportationplace/index?is_public_ignore=1">Места выгрузки перевозок</a></li>
                <li <?php if(strpos($siteData->url, '/shopworkshift/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ballast/shopworkshift/index?is_public_ignore=1">Смены</a></li>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ballast/shopoperation/index?is_public_ignore=1">Операторы</a></li>

            </ul>
        </li>
    <?php } ?>
</ul>