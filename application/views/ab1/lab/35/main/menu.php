<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopclientcontract/') && !Request_RequestParams::getParamBoolean('is_material_raw')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopclientcontract/index?client_contract_status_id=1">Договоры</a></li>
    <li <?php if(strpos($siteData->url, '/shopclientcontract/') && Request_RequestParams::getParamBoolean('is_material_raw')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopclientcontract/index?is_material_raw=1&client_contract_status_id=1">Договоры материалов и сырья</a></li>
    <li <?php if(strpos($siteData->url, '/shopboxcar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopboxcar/index">Вагоны</a></li>
    <li <?php if(strpos($siteData->url, '/shopcartomaterial/') && Request_RequestParams::getParamBoolean('is_weighted')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopcartomaterial/index?is_weighted=1">Машины с материалом</a></li>
    <li <?php if(strpos($siteData->url, '/shopcartomaterial/') && !Request_RequestParams::getParamBoolean('is_weighted')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopcartomaterial/index?is_weighted=0">Добавки</a></li>
    <li <?php if(strpos($siteData->url, '/shopproductstorage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopproductstorage/index">Продукция на склад</a></li>
    <li <?php if(strpos($siteData->url, '/shopmaterialmoisture/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopmaterialmoisture/index">Влажность материала</a></li>
    <li <?php if(strpos($siteData->url, '/shopmaterialdensity/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopmaterialdensity/index">Плотность материала</a></li>
    <li <?php if(strpos($siteData->url, '/shopcar/asu')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopcar/asu?shop_branch_id=<?php echo $siteData->shopID;?>">Очередь на погрузку</a></li>
    <li <?php if(strpos($siteData->url, '/shopcar/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopcar/index">История</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Сводная <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if((strpos($siteData->url, '/shopstorage/')) || (strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopstorage/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Склад</a></li>
            <li <?php if(Request_RequestParams::getParamBoolean('is_import_car') && (strpos($siteData->url, '/shopcartomaterial/') || strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopcartomaterial/statistics?shop_branch_id=<?php echo $siteData->shopID;?>&is_import_car=1">Завоз материалов</a></li>
            <li <?php if(!Request_RequestParams::getParamBoolean('is_import_car') && (strpos($siteData->url, '/shopcartomaterial/statistics') || strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopcartomaterial/statistics?shop_branch_id=<?php echo $siteData->shopID;?>&is_import_car=0">Перемещение материалов</a></li>
            <li <?php if(Request_RequestParams::getParamInt('shop_client_id') === NULL && strpos($siteData->url, '/shopboxcar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopboxcar/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Приём вагонов</a></li>
            <li <?php if(strpos($siteData->url, '/shopballast/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopballast/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Балласт</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Испытания <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopanalysis/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopanalysis/index">Испытания</a></li>
            <li <?php if(strpos($siteData->url, '/shopanalysisplace/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopanalysisplace/index">Места испытаний</a></li>
            <li <?php if(strpos($siteData->url, '/shopanalysistype/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopanalysistype/index">Виды испытаний</a></li>
            <li <?php if(strpos($siteData->url, '/shopanalysisact/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopanalysisact/index">Акты отбора для испытаний</a></li>
            <li <?php if(strpos($siteData->url, '/shopanalysisacttype/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopanalysisacttype/index">Виды актов испытаний</a></li>
            <li <?php if(strpos($siteData->url, '/shopequipment/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopequipment/index">Оборудования</a></li>
            <li <?php if(strpos($siteData->url, '/shopequipmentstate/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopequipmentstate/index">Состояния оборудований</a></li>
            <li <?php if(strpos($siteData->url, '/shopequipmentrepair/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopequipmentrepair/index">Журнал ремонта оборудований</a></li>
            <li <?php if(strpos($siteData->url, '/shopequipmentcondition/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopequipmentcondition/index">Журнал исправности оборудования</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopworkerentryexit/history">КПП</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopreport/index">Отчеты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopproduct/print_formula')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopproduct/print_formula?is_public_ignore=1">Печать рецептов</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/lab/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>