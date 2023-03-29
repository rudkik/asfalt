<ul class="nav nav-tabs">
    <?php if($siteData->operation->getShopTableUnitID()){ ?>
        <li <?php if(strpos($siteData->url, '/shoppiece/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shoppiece/index">ЖБИ и БС</a></li>
        <li <?php if(strpos($siteData->url, '/shopmovecar/') && (strpos($siteData->url, '/shopmovecar/history') == FALSE)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopmovecar/index">Перемещение</a></li>
        <li <?php if(strpos($siteData->url, '/shoplesseecar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shoplesseecar/index">Ответ.хранение</a></li>
        <li <?php if(strpos($siteData->url, '/shopreport/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopreport/index">Отчеты</a></li>
    <?php }else{ ?>
        <li <?php if(strpos($siteData->url, '/shopcar/') && (strpos($siteData->url, '/shopcar/history') == FALSE)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopcar/index">Реализация</a></li>
        <li <?php if(strpos($siteData->url, '/shopmovecar/') && (strpos($siteData->url, '/shopmovecar/history') == FALSE)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopmovecar/index">Перемещение</a></li>
        <li <?php if(strpos($siteData->url, '/shoppiece/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shoppiece/index">ЖБИ и БС</a></li>
        <li <?php if(strpos($siteData->url, '/shoppayment/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shoppayment/index">Счета</a></li>
        <li <?php if(strpos($siteData->url, '/shoppaymentreturn/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shoppaymentreturn/index">Возврат</a></li>
        <li <?php if(strpos($siteData->url, '/shopcar/history')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopcar/history">История реализации</a></li>
        <li <?php if(strpos($siteData->url, '/shopmovecar/history')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopmovecar/history">История перемещения</a></li>
        <li <?php if(strpos($siteData->url, '/shoplesseecar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shoplesseecar/index">Ответ.хранение</a></li>
        <li role="presentation" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Возмещение брака <span class="caret"></span> </a>
            <ul class="dropdown-menu">
                <li <?php if(strpos($siteData->url, '/shopdefectcar/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopdefectcar/index">В очередь</a></li>
                <li <?php if(strpos($siteData->url, '/shopdefectcar/history')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopdefectcar/history">История</a></li>
            </ul>
        </li>
        <li <?php if(strpos($siteData->url, '/shopconsumable/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopconsumable/index">Расходники</a></li>
        <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopworkerentryexit/history">КПП</a></li>
        <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopreport/index">Отчеты</a></li>
        <li <?php if(strpos($siteData->url, '/shopfinish/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopfinish/index">Конец дня</a></li>
        <li <?php if(strpos($siteData->url, '/shopxml/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopxml/index">Загрузка c 1C</a></li>
        <li role="presentation" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
            <ul class="dropdown-menu">
                <li <?php if(strpos($siteData->url, '/shopclient/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopclient/index?is_public_ignore=1">Клиенты</a></li>
                <li <?php if(strpos($siteData->url, '/shopmoveclient/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopmoveclient/index?is_public_ignore=1">Подразделения</a></li>
                <?php if($siteData->operation->getIsAdmin()){ ?>
                    <li <?php if(strpos($siteData->url, '/shopproduct/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopproduct/index?is_public_ignore=1">Продукты</a></li>
                    <li <?php if(strpos($siteData->url, '/shopproductrubric/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopproductrubric/index?is_public_ignore=1">Рубрики продукции</a></li>
                    <li <?php if(strpos($siteData->url, '/shopdelivery/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopdelivery/index?is_public_ignore=1">Доставка</a></li>
                    <li <?php if(strpos($siteData->url, '/shopproductdelivery/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopproductdelivery/index?is_public_ignore=1">Связь продукции и доставки</a></li>
                    <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopoperation/index?is_public_ignore=1">Операторы</a></li>
                    <li <?php if(strpos($siteData->url, '/shopcashbox/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopcashbox/index?is_public_ignore=1">Фискальные регистраторы</a></li>
                    <li <?php if(strpos($siteData->url, '/shopcashboxterminal/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/cash/shopcashboxterminal/index">Постерминалы</a></li>

                <?php } ?>
            </ul>
        </li>
    <?php } ?>
</ul>