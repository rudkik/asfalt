<?php if ((Func::isShopMenu('shopgoodcatalog/index?type='.$data->id, array(), $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgoodcatalog/index?type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            Рубрики <?php echo $data->values['name'];?>
        </a>
    </li>
<?php } ?>

<?php if ((Func::isShopMenu('shopgood/index?type='.$data->id, array(), $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgood/index?type=<?php echo $data->id; ?>&is_group=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            <?php echo $data->values['name'];?>
        </a>
    </li>
<?php } ?>

<?php if ((Func::isShopMenu('shopgood/group?type='.$data->id, array(), $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgood/index?type=<?php echo $data->id; ?>&is_group=1<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            Группы (<?php echo $data->values['name'];?>)
        </a>
    </li>
<?php } ?>

<li class="divider" role="presentation"></li>

<?php if ((Func::isShopMenu('shopattribute/index?type='.$data->id, array(), $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopattribute/index?type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            Атрибуты (<?php echo $data->values['name'];?>)
        </a>
    </li>
<?php } ?>

<?php if ((Func::isShopMenu('shopattributecatalog/index?type='.$data->id, array(), $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopattributecatalog/index?type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            Рубрики атрибутов (<?php echo $data->values['name'];?>)
        </a>
    </li>
<?php } ?>

<?php if ((Func::isShopMenu('shopattributegroup/index?type='.$data->id, array(), $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopattributegroup/index?type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            Группы атрибутов (<?php echo $data->values['name'];?>)
        </a>
    </li>
<?php } ?>