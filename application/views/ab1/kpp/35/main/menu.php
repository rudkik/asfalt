<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/index') && Request_RequestParams::getParamBoolean('is_exit') !== false){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/kpp/shopworkerentryexit/index">Вход/выход</a></li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/index') && Request_RequestParams::getParamBoolean('is_exit') === false){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/kpp/shopworkerentryexit/index?is_exit=0">На территории</a></li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')
        && strpos($siteData->url, '/shopworkerentryexit/move') === false
        && strpos($siteData->url, '/shopworkerentryexit/time_work') === false
        && strpos($siteData->url, '/shopworkerentryexit/index') === false){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/kpp/shopworkerentryexit/history">История</a></li>
    <?php if($siteData->operation->getIsAdmin()){ ?>
        <li <?php if(strpos($siteData->url, '/shopworkeraccess/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/kpp/shopworkeraccess/index">Доступы</a></li>
        <li <?php if(strpos($siteData->url, '/shopworkerentryexitlog/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/kpp/shopworkerentryexitlog/index">Лог пробития карточек</a></li>
        <li <?php if(strpos($siteData->url, '/shopworkerentryexit/time_work')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/kpp/shopworkerentryexit/time_work">Отработанное время</a></li>
        <li <?php if(strpos($siteData->url, '/shopworkerentryexit/move')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/kpp/shopworkerentryexit/move">Перемещение работников</a></li>
    <?php } ?>
    <li <?php if(strpos($siteData->url, '/guest/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/kpp/guest/index">Список гостей</a></li>
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/kpp/shopreport/index">Отчеты</a></li>
    <?php if($siteData->operation->getIsAdmin()){ ?>
        <li role="presentation" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
            <ul class="dropdown-menu">
                <li <?php if(strpos($siteData->url, '/scheduletype/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/kpp/scheduletype/index?is_public_ignore=1">Виды графиков</a></li>
                <li <?php if(strpos($siteData->url, '/misstype/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/kpp/misstype/index?is_public_ignore=1">Виды отсутствий</a></li>
                <li <?php if(strpos($siteData->url, '/shopworkerdepartment/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/kpp/shopworkerdepartment/index?is_public_ignore=1">Отделы работников</a></li>
                <li <?php if(strpos($siteData->url, '/shopworkerpassage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/kpp/shopworkerpassage/index?is_public_ignore=1">Точки входа</a></li>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/kpp/shopoperation/index?is_public_ignore=1">Операторы</a></li>
            </ul>
        </li>
    <?php } ?>
</ul>