<?php if ((Func::isShopMenu('shopreturn/index?type='.$data->id, $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreturn/index?is_public_ignore=1&type=<?php echo $data->id; ?>&is_group=0<?php if($siteData->branchID > 0){echo '&shop_return_id='.$siteData->returnID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            <?php echo $data->values['name'];?>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopreturn/branch?type='.$data->id, $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreturn/index?is_public_ignore=1&type=<?php echo $data->id; ?>&is_group=0<?php if($siteData->branchID > 0){echo '&shop_return_id='.$siteData->returnID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            <?php echo $data->values['name'];?>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopreport/branch/return?type='.$data->id, $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreport/branch/return?type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_bill_id='.$siteData->billID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            <?php echo $data->values['name'];?> отчеты
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopreport/good/return?type='.$data->id, $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreport/good/return?type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_bill_id='.$siteData->billID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            Возвращенные товары отчеты
        </a>
    </li>
<?php } ?>
<?php echo $data->additionDatas['view::_shop/_table/catalog/menu/top/one/child']; ?>