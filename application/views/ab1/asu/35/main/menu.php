<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopcar/shipment')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/asu/shopcar/shipment">Погрузка</a></li>
    <li <?php if(strpos($siteData->url, '/shopcar/total')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/asu/shopcar/total">Итоги по дням</a></li>
    <li <?php if(strpos($siteData->url, '/shopcar/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/asu/shopcar/index">История</a></li>
    <li <?php if(strpos($siteData->url, '/shopmovecar/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/asu/shopmovecar/index">История перемещения</a></li>
    <li <?php if(strpos($siteData->url, '/shopworkerentryexit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/asu/shopworkerentryexit/history">КПП</a></li>
    <?php if($siteData->operation->getIsAdmin()){ ?>
        <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/asu/shopoperation/index">Операторы</a></li>
    <?php } ?>
</ul>