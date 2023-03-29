<?php if ((Func::isShopMenu('shopbill/index?type='.$data->id, $siteData))){ ?>
    <li <?php if(!(($siteData->controllerName == 'shopbill')
        && (Request_RequestParams::getParamInt('type') == $data->id))){echo 'class="menu-left"';} ?>>
        <a href="<?php echo Func::getFullURL($siteData, '/shopbill/index', array(), array('is_public_ignore' => 1, 'type' => $data->id, 'is_group' => 0)); ?>"><i class="fa fa-circle-o text-light-blue"></i>
            <span><?php echo $data->values['name'];?></span>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopbill/branch?type='.$data->id, $siteData))){ ?>
    <li <?php if(!(($siteData->controllerName == 'shopbill')
        && (Request_RequestParams::getParamInt('type') == $data->id))){echo 'class="menu-left"';} ?>>
        <a href="<?php echo Func::getFullURL($siteData, '/shopbill/index', array(), array('is_public_ignore' => 1, 'type' => $data->id, 'is_group' => 0)); ?>"><i class="fa fa-circle-o text-light-blue"></i>
            <span><?php echo $data->values['name'];?> филиалы</span>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopreport/branch/bill?type='.$data->id, $siteData))){ ?>
    <li <?php if(!(($siteData->controllerName == 'shopreport')
        && (Request_RequestParams::getParamInt('type') == $data->id))){echo 'class="menu-left"';} ?>>
        <a href="<?php echo Func::getFullURL($siteData, '/shopreport/branch/bill', array(), array('type' => $data->id)); ?>"><i class="fa fa-circle-o text-light-blue"></i>
            <span><?php echo $data->values['name'];?> отчеты</span>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopreport/good/bill?type='.$data->id, $siteData))){ ?>
    <li <?php if(!(($siteData->controllerName == 'shopreport')
        && (Request_RequestParams::getParamInt('type') == $data->id))){echo 'class="menu-left"';} ?>>
        <a href="<?php echo Func::getFullURL($siteData, '/shopreport/good/bill', array(), array('type' => $data->id)); ?>"><i class="fa fa-circle-o text-light-blue"></i>
            <span>Проданные товары отчеты</span>
        </a>
    </li>
<?php } ?>
<?php echo $data->additionDatas['view::_shop/_table/catalog/menu/one/child']; ?>