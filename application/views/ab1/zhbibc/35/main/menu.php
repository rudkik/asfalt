<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopcar/') && (strpos($siteData->url, '/shopcar/history') == FALSE)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/zhbibc/shopcar/index">Реализация</a></li>
    <li <?php if(strpos($siteData->url, '/shopmovecar/') && (strpos($siteData->url, '/shopmovecar/history') == FALSE)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/zhbibc/shopmovecar/index">Перемещение</a></li>
    <li <?php if(strpos($siteData->url, '/shoppiece/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/zhbibc/shoppiece/index">ЖБИ и БС</a></li>
    <li <?php if(strpos($siteData->url, '/shopcar/history')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/zhbibc/shopcar/history">История реализации</a></li>
    <li <?php if(strpos($siteData->url, '/shopmovecar/history')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/zhbibc/shopmovecar/history">История перемещения</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Возмещение брака <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopdefectcar/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/zhbibc/shopdefectcar/index">В очередь</a></li>
            <li <?php if(strpos($siteData->url, '/shopdefectcar/history')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/zhbibc/shopdefectcar/history">История</a></li>
        </ul>
    </li>
    <li <?php if(strpos($siteData->url, '/shoplesseecar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/zhbibc/shoplesseecar/index">Ответ.хранение</a></li>
    <li <?php if(strpos($siteData->url, '/shopcartomaterial/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/zhbibc/shopcartomaterial/index"">Машины с материалом</a></li>
    <li <?php if(strpos($siteData->url, '/shopcartomaterial/') && strpos($siteData->url, '/shopcartomaterial/index') === false){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/zhbibc/shopcartomaterial/move">Перемещение материалов</a></li>
    <li <?php if(strpos($siteData->url, '/shopproductstorage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/zhbibc/shopproductstorage/index">Продукция на склад</a></li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/zhbibc/shopworkerentryexit/history">КПП</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/zhbibc/shopreport/index">Отчеты</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopclient/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/zhbibc/shopclient/index?is_public_ignore=1">Клиенты</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/zhbibc/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>
</ul>