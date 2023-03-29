<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopcar/ttn')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopcar/ttn">ТТН</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Рецепты <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopproduct/recipes')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopproduct/recipes">Рецепты продукции</a></li>
            <li <?php if(strpos($siteData->url, '/shopmaterial/recipes')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopmaterial/recipes">Рецепты материалов</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shopcartomaterial/') && Request_RequestParams::getParamBoolean('is_weighted')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopcartomaterial/index?is_weighted=1">Машины с материалом</a></li>
    <li <?php if(strpos($siteData->url, '/shopcartomaterial/') && !Request_RequestParams::getParamBoolean('is_weighted')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopcartomaterial/index?is_weighted=0">Добавки</a></li>
    <li <?php if(strpos($siteData->url, '/shopcar/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopcar/index">История</a></li>
    <li <?php if(strpos($siteData->url, '/shoppieceitem/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shoppieceitem/index">ЖБИ и БС</a></li>
    <li <?php if(strpos($siteData->url, '/shopmovecar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopmovecar/index">История перемещения</a></li>
    <li <?php if(strpos($siteData->url, '/shopdefectcar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopdefectcar/index">Возмещение за брак</a></li>
    <li <?php if(strpos($siteData->url, '/shopmoveother/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopmoveother/index">Прочие машины</a></li>
    <li style="display: none" <?php if(strpos($siteData->url, '/shoplesseecar/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shoplesseecar/index">Ответ.хранение</a></li>
    <li <?php if(strpos($siteData->url, '/shopcar/formula')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopcar/formula">Рецепты реализации</a></li>
    <li <?php if(strpos($siteData->url, '/shopregistermaterial/total')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopregistermaterial/total">Материальный отчет</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> НБЦ <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopmaterialstorage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopmaterialstorage/total">Остатки кубов готовой продукции</a></li>
            <li <?php if(strpos($siteData->url, '/shoprawstorage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shoprawstorage/total">Остатки сырьевого парка</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopworkerentryexit/history">КПП</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopreport/index">Отчеты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopmaterial/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopmaterial/index?is_public_ignore=1">Материалы</a></li>
            <li <?php if(strpos($siteData->url, '/shopmaterialrubric/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopmaterialrubric/index?is_public_ignore=1">Рубрики материалов</a></li>
            <li <?php if(strpos($siteData->url, '/shopheap/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopheap/index?is_public_ignore=1">Места хранения материалов</a></li>
            <li <?php if(strpos($siteData->url, '/shopraw/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopraw/index?is_public_ignore=1">Сырье</a></li>
            <li <?php if(strpos($siteData->url, '/shopdaughter/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopdaughter/index?is_public_ignore=1">Поставщики материалов</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/abc/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>