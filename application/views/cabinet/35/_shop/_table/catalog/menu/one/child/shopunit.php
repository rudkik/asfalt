<?php if ((Func::isShopMenu('shoptableunit/group?type='.$data->id, $siteData))) { ?>
    <li <?php if((Func::isCurrentMenu($siteData,'shoptableunit')) && (Request_RequestParams::getParamInt('type') == $data->id)){}else{echo 'class="menu-left"';} ?>>
        <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptableunit/index?is_public_ignore=1&table_id=<?php echo $data->values['root_table_id']; ?>&type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-blue"></i>
            <span><?php echo $data->values['name'];?></span>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shoptableunitrubric/index?type='.$data->id, $siteData))) { ?>
    <li <?php if((Func::isCurrentMenu($siteData,'shoptableunitrubric')) && (Request_RequestParams::getParamInt('type') == $data->id)){}else{echo 'class="menu-left"';} ?>>
        <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablerubric/index?is_public_ignore=1&table_id=<?php echo Model_Shop_Table_Unit::TABLE_ID; ?>&type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-blue"></i>
            <span>Рубрика <?php echo $data->values['name'];?></span>
        </a>
    </li>
<?php } ?>
