<?php $interfaceIDs = Arr::path($siteData->operation->getOptionsArray(), 'interface_ids', array()); ?>
<?php if(!empty($interfaceIDs) || $siteData->operation->getShopTableRubricID() == 0){ ?>
    <li class="dropdown tasks-menu bg-blue pull-right">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-flag-o" style="margin-right: 5px"></i>
            <span class="hidden-xs">
            <?php
            switch ($siteData->interfaceID){
                case Model_Ab1_Shop_Operation::RUBRIC_CASH:
                    echo 'Малый сбыт';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_ZHBIBC:
                    echo 'ЖБИ и БС';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_WEIGHT:
                    echo 'Весовая';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_ASU:
                    echo 'АСУ';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_SBYT:
                    echo 'СБЫТ';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_GENERAL:
                    echo 'Главный бухгалтер';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_BOOKKEEPING:
                    echo 'Бухгалтерия';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_DIRECTOR:
                    echo 'Руководитель';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_BALLAST:
                    echo 'Балласт';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_RECEPE:
                    echo 'Рецепты';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_BID:
                    echo 'Заявки';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_TRAIN:
                    echo 'Прием вагонов';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_ABC:
                    echo 'АБЦ';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_OWNER:
                    echo 'Директор';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_OGM:
                    echo 'ОГМ';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_PTO:
                    echo 'ПТО';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_PEO:
                    echo 'ФЭС';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_ATC:
                    echo 'АТЦ';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_CASHBOX:
                    echo 'Касса';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_JURIST:
                    echo 'Юрист';
                    break;
                case 0:
                    echo 'Админ';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_CRUSHER:
                    echo 'Начальник участка (дробилки)';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_MAKE:
                    echo 'Директор по производству';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_LAB:
                    echo 'Лаборатория';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_ECOLOGIST:
                    echo 'Эколог';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_SGE:
                    echo 'СГЭ';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_SALES:
                    echo 'Продажи';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_NBC:
                    echo 'НБЦ';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_KPP:
                    echo 'КПП';
                    break;
                case Model_Ab1_Shop_Operation::RUBRIC_CONTROL:
                    echo 'Диспетчерская';
                    break;
            }
            ?>
        </span>
        </a>
        <ul class="dropdown-menu" style="max-height: 300px;overflow-y: auto;">
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_ABC, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/abc/shopreport/index">АБЦ</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs)){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/shopoperation/index">Админ</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_ASU, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/asu/shopcar/shipment">АСУ</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_ATC, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/atc/shopreport/index">АТЦ</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_BALLAST, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/ballast/shopballast/index">Балласт</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_BOOKKEEPING, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/bookkeeping/shoppricelist/index">Бухгалтерия</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopcar/entry">Весовая</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_GENERAL, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/general/shoppricelist/index">Главный бухгалтер</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_OWNER, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/owner/shopproductrubric/statistics">Директор</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_MAKE, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/make/shopreport/index">Директор по производству</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_CONTROL, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/control/shoprawstorage/total">Диспетчерская</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_ZHBIBC, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/zhbibc/shoppiece/index">ЖБИ и БС</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_BID, $interfaceIDs) !== false){?>
                <li style="display: none" class=""><a href="<?php echo $siteData->urlBasic; ?>/bid/shopplan/index">Заявки</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_CASHBOX, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/cashbox/shoppayment/index">Касса</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_KPP, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/kpp/shopreport/index">КПП</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_LAB, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/lab/shopreport/index">Лаборатория</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_CASH, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/cash/shopcar/index">Малый сбыт</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_CRUSHER, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/crusher/shopraw/recipes">Начальник участка (дробилки)</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_NBC, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/nbc/shopreport/index">НБЦ</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_OGM, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/ogm/shopcar/asu">ОГМ</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_TRAIN, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/train/shopboxcartrain/index">Прием вагонов</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_SALES, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/sales/shopreport/index">Продажи</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_PTO, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/pto/shopreport/index">ПТО</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_RECEPE, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/recipe/shopproduct/recipes">Рецепты</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_DIRECTOR, $interfaceIDs) !== false){?>
                <li style="display: none" class=""><a href="<?php echo $siteData->urlBasic; ?>/director/shopcar/history">Руководитель</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_SBYT, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shopreport/index">СБЫТ</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_SGE, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/sge/shopclientcontract/index?client_contract_status_id=1">СГЭ</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_PEO, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/peo/shopreport/index">ФЭС</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_ECOLOGIST, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/ecologist/shopreport/index">Эколог</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_JURIST, $interfaceIDs) !== false){?>
                <li class="header"><a href="<?php echo $siteData->urlBasic; ?>/jurist/shopclientcontract/index">Юрист</a></li>
            <?php }?>
        </ul>
    </li>
<?php } ?>
