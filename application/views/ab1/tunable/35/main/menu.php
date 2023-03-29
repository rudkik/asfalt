<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shoppaymentplan/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/tunable/shoppaymentplan/index">План оплат клиентов</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/tunable/shopreport/index">Отчеты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopbranch/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/tunable/shopbranch/index?is_public_ignore=1">Филиалы</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/tunable/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>