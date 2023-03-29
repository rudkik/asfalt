<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopcar/asu')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ecologist/shopcar/asu">Очередь на погрузку</a></li>
    <li <?php if(strpos($siteData->url, '/shopcartomaterial/') && strpos($siteData->url, '/shopcartomaterial/statistics') === false){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ecologist/shopcartomaterial/index">Машины с материалом</a></li>
    <li <?php if(strpos($siteData->url, '/shopclientcontract/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ecologist/shopclientcontract/index?client_contract_status_id=1">Договоры</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Сводная <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(((strpos($siteData->url, '/shopproductrubric/statistics')) || (strpos($siteData->url, '/shopproduct/statistics'))) && (Request_RequestParams::getParamInt('shop_client_id') === NULL)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ecologist/shopproductrubric/statistics">Реализация</a></li>
            <li <?php if(strpos($siteData->url, '/shopballast/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ecologist/shopballast/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Балласт</a></li>
            <li <?php if((strpos($siteData->url, '/shopstorage/')) || (strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ecologist/shopstorage/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Склад</a></li>
            <li <?php if((strpos($siteData->url, '/shopdelivery/')) || (strpos($siteData->url, '/shopdaughter/'))){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ecologist/shopdelivery/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Доставка</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ecologist/shopworkerentryexit/history">КПП</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ecologist/shopreport/index">Отчеты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ecologist/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>