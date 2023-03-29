<?php if ((Func::isShopMenu('shopbranchcatalog/index?type='.$data->id, array(), $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbranchcatalog/index?type=<?php echo $data->id; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            Рубрики <?php echo $data->values['name'];?>
        </a>
    </li>
<?php } ?>

<?php if ((Func::isShopMenu('shopbranch/index?type='.$data->id, array(), $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbranch/index?type=<?php echo $data->id; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            <?php echo $data->values['name'];?>
        </a>
    </li>
<?php } ?>