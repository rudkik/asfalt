<?php if ((Func::isShopMenu('shoptableparam/group?type='.$data->id, $siteData))) { ?>
    <li <?php if((Func::isCurrentMenu($siteData,'shoptableparam')) && (Request_RequestParams::getParamInt('type') == $data->id)){}else{echo 'class="menu-left"';} ?>>
        <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptableparam/index?is_public_ignore=1&table_id=<?php echo $data->values['root_table_id']; ?>&type=<?php echo $data->id; ?>&param_index=<?php echo $data->values['param_index']; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-blue"></i>
            <span><?php echo $data->values['name'];?></span>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shoptableparamrubric/index?type='.$data->id, $siteData))) { ?>
    <li <?php if((Func::isCurrentMenu($siteData,'shoptableparamrubric')) && (Request_RequestParams::getParamInt('type') == $data->id)){}else{echo 'class="menu-left"';} ?>>
        <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablerubric/index?is_public_ignore=1&table_id=<?php echo Model_Shop_Table_Brand::TABLE_ID; ?>&type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-blue"></i>
            <span>Рубрика <?php echo $data->values['name'];?></span>
        </a>
    </li>
<?php } ?>