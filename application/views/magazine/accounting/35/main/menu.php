<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopreceive/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopreceive/index">Загрузка ЭСФ</a></li>
    <li <?php if(strpos($siteData->url, '/shopinvoice/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopinvoice/index">Накладные / ЭСФ</a></li>
    <li <?php if(strpos($siteData->url, '/shopreceiveitemgtd/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopreceiveitemgtd/index">Продукты из ЭСФ</a></li>
    <li <?php if(strpos($siteData->url, '/shoptotal/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shoptotal/index">Ведомость</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopreport/index">Отчеты</a></li>
    <li <?php if(strpos($siteData->url, '/shopxml/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopxml/index">Обмен с 1С</a></li>

    <li <?php if(strpos($siteData->url, '/shopconsumable/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopconsumable/index">Расходники</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Реализация <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shoprealization/')&& Request_RequestParams::getParamInt('is_special') < 1){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shoprealization/index">Реализация</a></li>
            <li <?php if(strpos($siteData->url, '/shoprealization/') && Request_RequestParams::getParamInt('is_special') == 1){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shoprealization/index?is_special=1">Спецпродукт</a></li>
            <li <?php if(strpos($siteData->url, '/shoprealization/') && Request_RequestParams::getParamInt('is_special') == 2){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shoprealization/index?is_special=2">Списание</a></li>
            <li <?php if(strpos($siteData->url, '/shoprealizationreturn/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shoprealizationreturn/index">Возврат реализации</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Склад <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shoprevise/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shoprevise/index">Ревизия</a></li>
            <li <?php if(strpos($siteData->url, '/shopmove/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopmove/index">Перемещение</a></li>
            <li <?php if(strpos($siteData->url, '/shopreturn/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopreturn/index">Возврат</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shoptalon/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shoptalon/index">Талоны сотрудников</a></li>
            <li <?php if(strpos($siteData->url, '/shopsupplier/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopsupplier/index">Поставщики</a></li>
            <li <?php if(strpos($siteData->url, '/shopworkerlimit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopworkerlimit/index">Лимиты работников</a></li>
            <li <?php if(strpos($siteData->url, '/shopwriteofftype/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopwriteofftype/index">Виды списания</a></li>
            <li <?php if(strpos($siteData->url, '/shopcard/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopcard/index">Карточки</a></li>
            <li <?php if(strpos($siteData->url, '/shopworker/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopworker/index">Работники</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopbranch/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopbranch/index">Филиалы</a></li>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopoperation/index">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Товары <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopproduction/stock')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopproduction/stock">Остатки продукции на складе</a></li>
            <li <?php if((strpos($siteData->url, '/shopproduction/')) && (!strpos($siteData->url, '/shopproduction/stock'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopproduction/index">Продукция</a></li>
            <li <?php if(strpos($siteData->url, '/shopproductrubricion/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopproductionrubric/index">Рубрики продукции</a></li>

            <li <?php if(strpos($siteData->url, '/shopproduct/stock')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopproduct/stock">Остатки продуктов на складе</a></li>
            <li <?php if((strpos($siteData->url, '/shopproduct/')) && (!strpos($siteData->url, '/shopproduct/stock'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopproduct/index">Продукты</a></li>
            <li <?php if(strpos($siteData->url, '/shopproductrubric/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/shopproductrubric/index">Рубрики продуктов</a></li>
            <li <?php if(strpos($siteData->url, '/unit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/accounting/unit/index">Единицы измерения</a></li>
        </ul>
    </li>
</ul>