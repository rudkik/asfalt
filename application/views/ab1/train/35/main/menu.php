<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopboxcartrain/contract') === false && strpos($siteData->url, '/shopboxcartrain/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/train/shopboxcartrain/index">Отгрузка</a></li>
    <li <?php if(strpos($siteData->url, '/shopboxcar/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/train/shopboxcar/index">Вагоны</a></li>
    <li <?php if(strpos($siteData->url, '/shopboxcartrain/contract')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/train/shopboxcartrain/contract">Статистика</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Сводная <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopboxcar/statistics_total')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/train/shopboxcar/statistics_total">Статистика по вагонам</a></li>
            <li <?php if(strpos($siteData->url, '/shopboxcar/statistics_total') === false && strpos($siteData->url, '/shopboxcar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/train/shopboxcar/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Приём вагонов</a></li>
            <li <?php if((Request_RequestParams::getParamInt('shop_client_id') > 0 && strpos($siteData->url, '/shopboxcar/index')) || strpos($siteData->url, '/shoplesseecar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/train/shoplesseecar/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Ответ.хранение</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/train/shopworkerentryexit/history">КПП</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/train/shopreport/index">Отчеты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopraw/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/train/shopraw/index?is_public_ignore=1">Сырье</a></li>
            <li <?php if(Request_RequestParams::getParamInt('client_type_id') == Model_Ab1_ClientType::CLIENT_TYPE_LESSEE && strpos($siteData->url, '/shopclient/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/train/shopclient/index?is_public_ignore=1&client_type_id=<?php echo Model_Ab1_ClientType::CLIENT_TYPE_LESSEE; ?>">Клиенты</a></li>
            <li <?php if(Request_RequestParams::getParamInt('client_type_id') == Model_Ab1_ClientType::CLIENT_TYPE_BUY_RAW && strpos($siteData->url, '/shopclient/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/train/shopclient/index?is_public_ignore=1&client_type_id=<?php echo Model_Ab1_ClientType::CLIENT_TYPE_BUY_RAW; ?>">Поставщики</a></li>
            <li style="display: none" <?php if(strpos($siteData->url, '/shopboxcarclient/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/train/shopboxcarclient/index?is_public_ignore=1">Поставщики</a></li>
            <li <?php if(strpos($siteData->url, '/shopboxcarfactory/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/train/shopboxcarfactory/index?is_public_ignore=1">Заводы</a></li>
            <li <?php if(strpos($siteData->url, '/shopboxcardeparturestation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/train/shopboxcardeparturestation/index?is_public_ignore=1">Станции отправления</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/train/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>