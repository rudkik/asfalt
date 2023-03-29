<?php if ((Func::isShopMenu('shopbranchcatalog/index?type='.$data->id, array(), $siteData))) { ?>
    <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopbranchcatalog/index'){echo 'class="menu-left"';} ?>>
        <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbranchcatalog/index?type=<?php echo $data->id; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-light-blue"></i>
            <span>Рубрики (<?php echo $data->values['name'];?>)</span>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopbranch/index?type='.$data->id, array(), $siteData))) { ?>
    <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopbranch/index'){echo 'class="menu-left"';} ?>>
        <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbranch/index?type=<?php echo $data->id; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-green"></i>
            <span><?php echo $data->values['name'];?></span>
        </a>
    </li>
<?php } ?>