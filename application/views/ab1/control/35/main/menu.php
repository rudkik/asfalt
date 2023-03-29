<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopboxcar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/control/shopboxcar/index">Вагоны</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Сырьевой парк <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shoprawstorage/total')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/control/shoprawstorage/total">Остатки</a></li>
            <li <?php if(strpos($siteData->url, '/shoprawstoragemetering/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/control/shoprawstoragemetering/index">Список замеров</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/control/shopworkerentryexit/history">КПП</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/control/shopreport/index">Отчеты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shoprawstorage/total') === false && strpos($siteData->url, '/shoprawstorage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/control/shoprawstorage/index?is_public_ignore=1">Сырьевой парк</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/control/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>