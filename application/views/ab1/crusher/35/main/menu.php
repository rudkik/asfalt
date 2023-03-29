<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shoprawmaterial/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/crusher/shoprawmaterial/index">Производство дробилками</a></li>
    <li <?php if(strpos($siteData->url, '/shopraw/recipe')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/crusher/shopraw/recipes">Рецепт балласта</a></li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/crusher/shopworkerentryexit/history">КПП</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/crusher/shopreport/index">Отчеты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/crusher/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>