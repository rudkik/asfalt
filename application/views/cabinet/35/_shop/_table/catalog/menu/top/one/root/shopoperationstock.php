<?php if ((Func::isShopMenu('shopoperationstock/index?type='.$data->id, $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/index?is_public_ignore=1&type=<?php echo $data->id; ?>&is_group=0<?php if($siteData->branchID > 0){echo '&shop_operation_stock_id='.$siteData->operationstockID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            <?php echo $data->values['name'];?>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopoperationstock/branch?type='.$data->id, $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/index?is_public_ignore=1&type=<?php echo $data->id; ?>&is_group=0<?php if($siteData->branchID > 0){echo '&shop_operation_stock_id='.$siteData->operationstockID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            <?php echo $data->values['name'];?>
        </a>
    </li>
<?php } ?>

<?php if ((Func::isShopMenu('shopoperationstock/branch?type='.$data->id, $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/index?is_public_ignore=1&type=<?php echo $data->id; ?>&is_group=0<?php if($siteData->branchID > 0){echo '&shop_operation_stock_id='.$siteData->operationstockID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            <?php echo $data->values['name'];?>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopreport/branch/operationstock?type='.$data->id, $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreport/branch/operationstock?type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_operation_stock_id='.$siteData->operationstockID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            <?php echo $data->values['name'];?> отчеты
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopreport/good/operationstock?type='.$data->id, $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreport/good/operationstock?type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_operation_stock_id='.$siteData->operationstockID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            Переданные товары отчеты
        </a>
    </li>
<?php } ?>
<?php echo $data->additionDatas['view::_shop/_table/catalog/menu/top/one/child']; ?>