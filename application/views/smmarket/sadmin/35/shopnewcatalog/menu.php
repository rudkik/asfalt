<?php if ((Func::isShopMenu('shopnewrubric/index?type='.$data->id, $siteData))) { ?>
    <li <?php if ((Func::isCurrentMenu($siteData,'shopnewrubric')) && (Request_RequestParams::getParamInt('type') == $data->id)){}else{echo 'class="menu-left"';} ?>>
        <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnewrubric/index?type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-aqua"></i>
            <span>Рубрики (<?php echo $data->values['name'];?>)</span>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopnew/index?type='.$data->id, $siteData))) { ?>
    <li <?php if((Func::isCurrentMenu($siteData,'shopnew')) && (Request_RequestParams::getParamInt('type') == $data->id)){}else{echo 'class="menu-left"';} ?>>
        <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnew/index?type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-blue"></i>
            <span><?php echo $data->values['name'];?></span>
        </a>
    </li>
<?php } ?>