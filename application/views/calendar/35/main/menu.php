<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shoptask/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/calendar/shoptask/index">Задачи</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopproduct/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/calendar/shopproduct/index">Продукты</a></li>
            <li <?php if(strpos($siteData->url, '/shoprubric/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/calendar/shoprubric/index">Рубрики</a></li>
            <li <?php if(strpos($siteData->url, '/shoppartner/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/calendar/shoppartner/index">Партнеры</a></li>
            <li <?php if(strpos($siteData->url, '/shopresult/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/calendar/shopresult/index">Результаты</a></li>
            <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/calendar/shopoperation/index">Операторы</a></li>
        </ul>
    </li>
</ul>