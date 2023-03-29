<?php
$islist = Func::isShopMenu('shopinformationdata/index?type='.$data->id, $siteData);

if ($islist > 0){ ?>

    <?php if ($islist > 1){ ?>
        <li class="treeview">
        <a href="#">
            <i class="fa fa-credit-card"></i> <span><?php echo $data->values['name'];?></span> <i
                class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
    <?php } ?>

    <?php if ((Func::isShopMenu('shopinformationdata/index?type='.$data->id, $siteData))) { ?>
        <li>
            <a menu="1" href="<?php echo $siteData->urlBasic; ?>/cabinet/shopinformationdata/index?shop_id=<?php echo $siteData->shopID; ?>&type=<?php echo $data->id; ?>"><i
                    class="fa fa-circle-o"></i> <?php echo $data->values['name'];?></a>
        </li>
    <?php } ?>
    <?php if ($islist > 1){ ?>
        </ul>
        </li>
    <?php } ?>
<?php } ?>