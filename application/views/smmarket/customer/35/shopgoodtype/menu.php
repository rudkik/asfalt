<?php if ((Func::isShopMenu('shopgoodcatalog/index?type='.$data->id, array(), $siteData))) { ?>
    <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopgoodcatalog/index'){echo 'class="menu-left"';} ?>>
        <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgoodcatalog/index?type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-light-blue"></i>
            <span>Рубрики (<?php echo $data->values['name'];?>)</span>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopgood/index?type='.$data->id, array(), $siteData))) { ?>
    <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopgood/index'){echo 'class="menu-left"';} ?>>
        <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgood/index?type=<?php echo $data->id; ?>&is_group=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-green"></i>
            <span><?php echo $data->values['name'];?></span>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopgood/group?type='.$data->id, array(), $siteData))) { ?>
    <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopgood/index'){echo 'class="menu-left"';} ?>>
        <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgood/index?type=<?php echo $data->id; ?>&is_group=1<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-gray"></i>
            <span>Группы <?php echo $data->values['name'];?></span>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopattribute/index?type='.$data->id, array(), $siteData))){ ?>
    <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopattribute/index'){echo 'class="menu-left"';} ?>>
        <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopattribute/index?type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-navy"></i>
            <span>Атрибуты (<?php echo $data->values['name'];?>)</span>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopattributecatalog/index?type='.$data->id, array(), $siteData))){ ?>
    <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopattributecatalog/index'){echo 'class="menu-left"';} ?>>
        <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopattributecatalog/index?type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-teal"></i>
            <span>Рубрики атрибутов (<?php echo $data->values['name'];?>)</span>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopattributegroup/index?type='.$data->id, array(), $siteData))){ ?>
    <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopattributegroup/index'){echo 'class="menu-left"';} ?>>
        <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopattributegroup/index?type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-olive"></i>
            <span>Группировка атрибутов (<?php echo $data->values['name'];?>)</span>
        </a>
    </li>
<?php } ?>