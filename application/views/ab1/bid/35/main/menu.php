<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopplan/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bid/shopplan/index">Заявки</a></li>
    <li <?php if(strpos($siteData->url, '/shopplantransport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bid/shopplantransport/index">Вывод спецтранспорта</a></li>
    <li <?php if(strpos($siteData->url, '/shopplanitem/reason')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bid/shopplanitem/reason">Заявки причины</a></li>
    <li <?php if(strpos($siteData->url, '/shopbid/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bid/shopbid/index">Заявки на месяц</a></li>
    <li <?php if(strpos($siteData->url, '/shopcar/asu')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bid/shopcar/asu?shop_branch_id=<?php echo $siteData->shopID;?>">Очередь на погрузку</a></li>
    <li <?php if(strpos($siteData->url, '/shopcompetitorprice/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bid/shopcompetitorprice/index">Цены конкурентов</a></li>
    <li <?php if(strpos($siteData->url, '/shopsupplierprice/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bid/shopsupplierprice/index">Цены поставщиков</a></li>
    <li <?php if(strpos($siteData->url, '/shopcar/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bid/shopcar/index">Машины на территории</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bid/shopreport/index">Отчеты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopspecialtransport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bid/shopspecialtransport/index?is_public_ignore=1">Спецтранспорт</a></li>
            <li <?php if(strpos($siteData->url, '/shopcompetitor/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bid/shopcompetitor/index?is_public_ignore=1">Конкуренты</a></li>
            <li <?php if(strpos($siteData->url, '/shopsupplier/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bid/shopsupplier/index?is_public_ignore=1">Поставщики</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopproductgroup/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bid/shopproductgroup/index?is_public_ignore=1">Группы продукции</a></li>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/bid/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>