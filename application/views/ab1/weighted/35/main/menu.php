<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopcar/entry')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopcar/entry">Очередь на въезд</a></li>
    <li <?php if((strpos($siteData->url, '/shopcar/exit')) && (strpos($siteData->url, '/shopcar/exit_empty') == FALSE)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopcar/exit">Очередь на выезд</a></li>
    <li <?php if(strpos($siteData->url, '/shopcar/exit_empty')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopcar/exit_empty">Пустые на выезд</a></li>
    <li <?php if(strpos($siteData->url, '/shopcartomaterial/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopcartomaterial/index">Машины с материалом</a></li>
    <li <?php if(strpos($siteData->url, '/shopmoveother/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopmoveother/index">Прочие машины</a></li>
    <li <?php if(strpos($siteData->url, '/shopmoveempty/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopmoveempty/index">Пустые машины</a></li>
    <li <?php if(strpos($siteData->url, '/shopcar/asu')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopcar/asu">Машины на погрузку</a></li>
    <li <?php if(strpos($siteData->url, '/shopcar/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopcar/index">История</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> История машин <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopmovecar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopmovecar/index">История перемещения</a></li>
            <li <?php if(strpos($siteData->url, '/shoplesseecar/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shoplesseecar/index">Ответ.хранение</a></li>
            <li <?php if(strpos($siteData->url, '/shopdefectcar/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopdefectcar/index">Возмещение брака</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Тара <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopcartare/') && Request_RequestParams::getParamInt('tare_type_id') == Model_Ab1_TareType::TARE_TYPE_OUR){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopcartare/index?tare_type_id=<?php echo Model_Ab1_TareType::TARE_TYPE_OUR; ?>">Наши машины</a></li>
            <li <?php if(strpos($siteData->url, '/shopcartare/') && Request_RequestParams::getParamInt('tare_type_id') == Model_Ab1_TareType::TARE_TYPE_CLIENT){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopcartare/index?tare_type_id=<?php echo Model_Ab1_TareType::TARE_TYPE_CLIENT; ?>">Машины клиентов</a></li>
            <li <?php if(strpos($siteData->url, '/shopcartare/') && Request_RequestParams::getParamInt('tare_type_id') == Model_Ab1_TareType::TARE_TYPE_OTHER){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopcartare/index?tare_type_id=<?php echo Model_Ab1_TareType::TARE_TYPE_OTHER; ?>">Тара прочие машины</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shopproductstorage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopproductstorage/index">Продукция на склад</a></li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopworkerentryexit/history">КПП</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopreport/index">Отчеты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopsubdivision/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopsubdivision/index">Подразделение</a></li>
            <li <?php if(strpos($siteData->url, '/shopheap/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopheap/index">Места хранения материалов</a></li>
            <li <?php if(strpos($siteData->url, '/shopmaterial/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopmaterial/index">Материалы</a></li>
            <li <?php if(strpos($siteData->url, '/shopmaterialother/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopmaterialother/index">Прочие материалы</a></li>
            <li <?php if(strpos($siteData->url, '/shopdaughter/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopdaughter/index">Отправители материалов</a></li>
            <li style="display: none" <?php if(strpos($siteData->url, '/shopclientmaterial/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopclientmaterial/index">Получатели материалов</a></li>
            <li <?php if(strpos($siteData->url, '/shopmoveplace/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopmoveplace/index">Места вывоза</a></li>
            <li <?php if(strpos($siteData->url, '/shoptransportcompany/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shoptransportcompany/index">Транспортные компании</a></li>
            <li <?php if(strpos($siteData->url, '/shopstorage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopstorage/index">Склады хранения готовой продукции</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopoperation/index">Операторы</a></li>
                <li <?php if(strpos($siteData->url, '/shopturnplace/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopturnplace/index">Места очередей</a></li>
                <li <?php if(strpos($siteData->url, '/shopturntype/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopturntype/index">Виды очередей</a></li>
            <?php }else{ ?>
                <li <?php if(strpos($siteData->url, '/shopturnplace/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/weighted/shopturnplace/index">Места очередей</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>