<?php if ((Func::isShopMenu('shopbill/index?type='.$data->id, $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbill/index?is_public_ignore=1&type=<?php echo $data->id; ?>&is_group=0<?php if($siteData->branchID > 0){echo '&shop_bill_id='.$siteData->billID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            <?php echo $data->values['name'];?>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopbill/branch?type='.$data->id, $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbill/index?is_public_ignore=1&type=<?php echo $data->id; ?>&is_group=0<?php if($siteData->branchID > 0){echo '&shop_bill_id='.$siteData->billID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            <?php echo $data->values['name'];?>
        </a>
    </li>
<?php } ?>

<?php if ((Func::isShopMenu('shopbill/branch?type='.$data->id, $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbill/index?is_public_ignore=1&type=<?php echo $data->id; ?>&is_group=0<?php if($siteData->branchID > 0){echo '&shop_bill_id='.$siteData->billID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            <?php echo $data->values['name'];?>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopreport/branch/bill?type='.$data->id, $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreport/branch/bill?type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_bill_id='.$siteData->billID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            <?php echo $data->values['name'];?> отчеты
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopreport/good/bill?type='.$data->id, $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreport/good/bill?type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_bill_id='.$siteData->billID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            Проданные отчеты
        </a>
    </li>
<?php } ?>
<?php echo $data->additionDatas['view::_shop/_table/catalog/menu/top/one/child']; ?>