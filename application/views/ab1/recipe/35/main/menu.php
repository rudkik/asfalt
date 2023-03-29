<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopformulamaterial/') || (strpos($siteData->url, '/shopmaterial/') && $siteData->url != '/recipe/shopmaterial/recipe')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/recipe/shopmaterial/recipes">Рецепты материалов</a></li>
    <li <?php if(strpos($siteData->url, '/shopformulaproduct/') || (strpos($siteData->url, '/shopproduct/') && $siteData->url != '/recipe/shopproduct/recipe')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/recipe/shopproduct/recipes">Рецепты продукции</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/recipe/shopreport/index">Отчеты</a></li>
    <li <?php if(strpos($siteData->url, '/shopmaterial/recipe') && strpos($siteData->url, '/shopmaterial/recipes') === false){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/recipe/shopmaterial/recipe">Активные рецепты материалов</a></li>
    <li <?php if(strpos($siteData->url, '/shopproduct/recipe') && strpos($siteData->url, '/shopproduct/recipes') === false){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/recipe/shopproduct/recipe">Активные рецепты продукции</a></li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/recipe/shopworkerentryexit/history">КПП</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopformulagroup/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/recipe/shopformulagroup/index?is_public_ignore=1">Группы рецептов</a></li>
            <li <?php if(strpos($siteData->url, '/shopmaterial/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/recipe/shopmaterial/index?is_public_ignore=1">Материалы</a></li>
            <li <?php if(strpos($siteData->url, '/shopraw/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/recipe/shopraw/index?is_public_ignore=1">Сырье</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/recipe/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>