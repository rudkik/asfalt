<?php $interfaceIDs = Arr::path($siteData->operation->getOptionsArray(), 'interface_ids', array()); ?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
		<ul class="nav nav-tabs">
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_ABC, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/abc/shopreport/index">АБЦ</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs)){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/shopoperation/index">Админ</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_ATC, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/atc/shopreport/index">АТЦ</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_ASU, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/asu/shopcar/shipment">АСУ</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_BALLAST, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/ballast/shopballast/index">Балласт</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_BOOKKEEPING, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/bookkeeping/shoppricelist/index">Бухгалтерия</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopcar/entry">Весовая</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_GENERAL, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/general/shoppricelist/index">Главный бухгалтер</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_OWNER, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/owner/shopproductrubric/statistics">Директор</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_MAKE, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/make/shopreport/index">Директор по производству</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_CONTROL, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/control/shoprawstorage/total">Диспетчерская</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_ZHBIBC, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/zhbibc/shoppiece/index">ЖБИ и БС</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_BID, $interfaceIDs) !== false){?>
                <li style="display: none" class=""><a href="<?php echo $siteData->urlBasic; ?>/bid/shopplan/index">Заявки</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_CASHBOX, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/cashbox/shoppayment/index">Касса</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_KPP, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/kpp/shopreport/index">КПП</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_LAB, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/lab/shopreport/index">Лаборатория</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_CASH, $interfaceIDs) !== false){?>
            <li class=""><a href="<?php echo $siteData->urlBasic; ?>/cash/shopcar/index">Малый сбыт</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_CRUSHER, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/crusher/shopraw/recipes">Начальник участка (дробилки)</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_NBC, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/nbc/shopreport/index">НБЦ</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_OGM, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/ogm/shopcar/asu">ОГМ</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_TRAIN, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/train/shopboxcartrain/index">Прием вагонов</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_SALES, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/sales/shoppricelist/index">Продажи</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_PTO, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/pto/shopreport/index">ПТО</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_RECEPE, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/recipe/shopproduct/recipes">Рецепты</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_DIRECTOR, $interfaceIDs) !== false){?>
                <li style="display: none" class=""><a href="<?php echo $siteData->urlBasic; ?>/director/shopcar/history">Руководитель</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_SBYT, $interfaceIDs) !== false){?>
            <li class=""><a href="<?php echo $siteData->urlBasic; ?>/sbyt/shoppricelist/index">СБЫТ</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_SGE, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/sge/shopclientcontract/index?client_contract_status_id=1">СГЭ</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_TECHNOLOGIST, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/technologist/shopreport/index">Технолог</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_PEO, $interfaceIDs) !== false){?>
            <li class=""><a href="<?php echo $siteData->urlBasic; ?>/peo/shopreport/index">ФЭС</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_ECOLOGIST, $interfaceIDs) !== false){?>
            <li class=""><a href="<?php echo $siteData->urlBasic; ?>/ecologist/shopreport/index">Эколог</a></li>
            <?php }?>
            <?php if(empty($interfaceIDs) || array_search(Model_Ab1_Shop_Operation::RUBRIC_JURIST, $interfaceIDs) !== false){?>
                <li class=""><a href="<?php echo $siteData->urlBasic; ?>/jurist/shopclientcontract/index">Юрист</a></li>
            <?php }?>
		</ul>
	</div>
</div>
