<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shoprealization/')&& Request_RequestParams::getParamInt('is_special') < 1){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shoprealization/index">Реализация</a></li>
    <li <?php if(strpos($siteData->url, '/shoprealization/') && Request_RequestParams::getParamInt('is_special') == 1){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shoprealization/index?is_special=1">Спецпродукт</a></li>
    <li <?php if(strpos($siteData->url, '/shoprealization/') && Request_RequestParams::getParamInt('is_special') == 2){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shoprealization/index?is_special=2">Списание</a></li>
    <li <?php if(strpos($siteData->url, '/shoprealizationreturn/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shoprealizationreturn/index">Возврат реализации</a></li>
    <li <?php if(strpos($siteData->url, '/shopreceive/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shopreceive/index">Приемка</a></li>
    <li <?php if(strpos($siteData->url, '/shoprevise/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shoprevise/index">Ревизия</a></li>
    <li <?php if(strpos($siteData->url, '/shopmove/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shopmove/index">Перемещение</a></li>
    <li <?php if(strpos($siteData->url, '/shopreturn/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shopreturn/index">Возврат</a></li>
    <li <?php if(strpos($siteData->url, '/shopconsumable/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shopconsumable/index">Расходники</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shopreport/index">Отчеты</a></li>
    <li <?php if(strpos($siteData->url, '/shopfinish/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shopfinish/index">Конец дня</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shoptalon/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shoptalon/index">Талоны сотрудников</a></li>
            <li <?php if(strpos($siteData->url, '/shopsupplier/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shopsupplier/index">Поставщики</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shopoperation/index">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Товары <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopproduction/stock')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shopproduction/stock">Остатки продукции на складе</a></li>
            <li <?php if((strpos($siteData->url, '/shopproduction/')) && (!strpos($siteData->url, '/shopproduction/stock'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shopproduction/index">Продукция</a></li>

            <li <?php if(strpos($siteData->url, '/shopproduct/stock')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shopproduct/stock">Остатки продуктов на складе</a></li>
            <li <?php if((strpos($siteData->url, '/shopproduct/')) && (!strpos($siteData->url, '/shopproduct/stock'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bar/shopproduct/index">Продукты</a></li>
        </ul>
    </li>
</ul>