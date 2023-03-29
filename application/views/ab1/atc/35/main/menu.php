<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shoptransportwaybill/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/shoptransportwaybill/index">Путевой лист</a></li>
    <?php $nameUser = $siteData->operation->values['email']['new'] ;
    if($nameUser == 'Любушкин.И' || $nameUser == 'Бедриков.А'  || $nameUser == 'Ващинин.А' ){ ?>
    <li <?php if(strpos($siteData->url, '/shoptransportrepair/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/shoptransportrepair/index">Ремонт транспорта</a></li>
    <?php } ?>
    <?php if($siteData->operation->getOperationTypeID() == Model_OperationType::ATC_MECHANIC || $siteData->operation->getIsAdmin() || $siteData->operation->getOperationTypeID() == Model_OperationType::ATC_CHIEF){ ?>
        <li <?php if(strpos($siteData->url, '/shoptransportrepair/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/shoptransportrepair/index">Ремонт транспорта</a></li>
        <li <?php if(strpos($siteData->url, '/shoptransportfueldepartment/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/shoptransportfueldepartment/index">Отделы списания ГСМ</a></li>
        <li <?php if(strpos($siteData->url, '/shoptransportfuelissue/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/shoptransportfuelissue/index">Поступление ГСМ</a></li>
        <li <?php if(strpos($siteData->url, '/shoptransportfuelexpense/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/shoptransportfuelexpense/index">Расход ГСМ</a></li>
        <li style="display: none" <?php if(strpos($siteData->url, '/shopclientcontract/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/shopclientcontract/index">Договоры</a></li>
    <?php } ?>
    <li <?php if(strpos($siteData->url, '/shopcar/check')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/shopcar/check">Проверка путевых листов</a></li>
    <?php if($siteData->operation->getOperationTypeID() == Model_OperationType::ATC_MECHANIC || $siteData->operation->getIsAdmin() || $siteData->operation->getOperationTypeID() == Model_OperationType::ATC_CHIEF){ ?>
        <li role="presentation" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> ГСМ <span class="caret"></span> </a>
            <ul class="dropdown-menu">
                <li <?php if(strpos($siteData->url, '/shoptransportsamplefuel/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/shoptransportsamplefuel/index">Акты замеров ГСМ в баках</a></li>
                <li <?php if(strpos($siteData->url, '/shoptransportfuelstorage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/shoptransportfuelstorage/index">Склад хранения топлива</a></li>

                <li <?php if(strpos($siteData->url, '/fueltype/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/fueltype/index">Виды ГСМ</a></li>
                <li <?php if(strpos($siteData->url, '/fuel/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/fuel/index">Сведения ГСМ</a></li>
                <li <?php if(strpos($siteData->url, '/fuelissue/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/fuelissue/index">Способы выдачи ГСМ</a></li>
                <li <?php if(strpos($siteData->url, '/season/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/season/index">Сезоны</a></li>
                <li <?php if(strpos($siteData->url, '/seasontime/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/seasontime/index">Периоды действия сезонов</a></li>
            </ul>
        </li>
        <li role="presentation" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Транспорт + водители <span class="caret"></span> </a>
            <ul class="dropdown-menu">
                <li <?php if(strpos($siteData->url, '/shoptransport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/shoptransport/index">Сведения о транспортных средствах</a></li>
                <li <?php if(strpos($siteData->url, '/shoptransportmark/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/shoptransportmark/index">Реестр ТС</a></li>
                <li <?php if(strpos($siteData->url, '/transportview/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/transportview/index">Виды транспорта</a></li>
                <li <?php if(strpos($siteData->url, '/transportwork/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/transportwork/index">Виды работ транспорта</a></li>
                <li <?php if(strpos($siteData->url, '/transporttype1c/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/transporttype1c/index">Типы транспорта 1С</a></li>
                <li <?php if(strpos($siteData->url, '/shoptransportdriver/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/shoptransportdriver/index">Сведения о водителях</a></li>
                <li <?php if(strpos($siteData->url, '/shoptransportclass/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/shoptransportclass/index">Классность водителей</a></li>
            </ul>
        </li>
        <li role="presentation" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Сводная <span class="caret"></span> </a>
            <ul class="dropdown-menu">
                <li <?php if(strpos($siteData->url, '/shoptransport/') || strpos($siteData->url, '/shoptransportwaybill/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shoptransport/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Транспорт</a></li>
                <li <?php if(strpos($siteData->url, '/fuel/') || strpos($siteData->url, '/shoptransportwaybill/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/fuel/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">ГСМ</a></li>
            </ul>
        </li>
    <?php } ?>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/shopworkerentryexit/history">КПП</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/shopreport/index">Отчеты</a></li>
    <?php if($siteData->operation->getIsAdmin()){ ?>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/atc/shopoperation/index?is_public_ignore=1">Операторы</a></li>
        </ul>
    </li>
    <?php } ?>
</ul>