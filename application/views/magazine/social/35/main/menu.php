<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shoptalon/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/social/shoptalon/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Выдача молока</a></li>
    <li <?php if(strpos($siteData->url, '/shopreceive/') || strpos($siteData->url, '/shopreceiveitem/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/social/shopreceive/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Поступило продуктов</a></li>
    <li <?php if(strpos($siteData->url, '/shopproductionrubric/') || (strpos($siteData->url, '/shoprealizationitem/') && intval(Request_RequestParams::getParamInt('shop_production_rubric_id')) > 0)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/social/shopproductionrubric/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Реализовано по продукции</a></li>
    <li <?php if((strpos($siteData->url, '/shoprealization/') && intval(Request_RequestParams::getParamInt('is_special')) < 1) || (strpos($siteData->url, '/shoprealizationitem/') && Request_RequestParams::getParamInt('shop_worker_id') > 0)){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/social/shoprealization/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Реализовано по покупателям</a></li>
    <li <?php if(strpos($siteData->url, '/shopmove/') || strpos($siteData->url, '/shopmoveitem/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/social/shopmove/statistics?shop_branch_id=<?php echo $siteData->shopID;?>">Перемещение</a></li>
    <li <?php if((strpos($siteData->url, '/shoprealization/') || strpos($siteData->url, '/shoprealizationitem/')) && Request_RequestParams::getParamInt('is_special') == Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/social/shoprealization/statistics?shop_branch_id=<?php echo $siteData->shopID;?>&is_special=<?php echo Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF;?>">Списание</a></li>

    <?php if($siteData->operation->getIsAdmin()){ ?>
        <li role="presentation" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
            <ul class="dropdown-menu">
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/social/shopoperation/index">Операторы</a></li>
            </ul>
        </li>
    <?php } ?>
</ul>