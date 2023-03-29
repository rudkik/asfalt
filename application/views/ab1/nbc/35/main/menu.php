<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopboxcar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/nbc/shopboxcar/index?is_date_arrival_empty=0&is_date_drain_to_empty=1">Вагоны</a></li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/nbc/shopworkerentryexit/history">КПП</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/nbc/shopreport/index">Отчеты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Кубы готовой продукции <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopmaterialstorage/total')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/nbc/shopmaterialstorage/total">Остатки</a></li>
            <li <?php if(strpos($siteData->url, '/shopmaterialstoragemetering/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/nbc/shopmaterialstoragemetering/index">Список замеров</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Сырьевой парк <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shoprawstorage/total')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/nbc/shoprawstorage/total">Остатки</a></li>
            <li <?php if(strpos($siteData->url, '/shoprawstoragemetering/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/nbc/shoprawstoragemetering/index">Список замеров</a></li>
            <li <?php if(strpos($siteData->url, '/shoprawstoragedrain/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/nbc/shoprawstoragedrain/index">Слив/загрузка сырьевого парка</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shoprawstorage/total') === false && strpos($siteData->url, '/shoprawstorage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/nbc/shoprawstorage/index?is_public_ignore=1">Сырьевой парк</a></li>
            <li <?php if(strpos($siteData->url, '/shoprawdrainchute/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/nbc/shoprawdrainchute/index?is_public_ignore=1">Битумные лотки слива НБЦ</a></li>
            <li <?php if(strpos($siteData->url, '/shopmaterialstorage/total') === false && strpos($siteData->url, '/shopmaterialstorage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/nbc/shopmaterialstorage/index?is_public_ignore=1">Кубы хранения готовой продукции</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/nbc/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>