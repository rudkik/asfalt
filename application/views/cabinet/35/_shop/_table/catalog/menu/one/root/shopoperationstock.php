<?php if ((Func::isShopMenu('shopoperationstock/index?type='.$data->id, $siteData))){ ?>
    <li <?php if(!(($siteData->controllerName == 'shopoperationstock')
        && (Request_RequestParams::getParamInt('type') == $data->id))){echo 'class="menu-left"';} ?>>
        <a href="<?php echo Func::getFullURL($siteData, '/shopoperationstock/index', array(), array('is_public_ignore' => 1, 'type' => $data->id, 'is_group' => 0)); ?>"><i class="fa fa-circle-o text-light-blue"></i>
            <span><?php echo $data->values['name'];?></span>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopoperationstock/branch?type='.$data->id, $siteData))){ ?>
    <li <?php if(!(($siteData->controllerName == 'shopoperationstock')
        && (Request_RequestParams::getParamInt('type') == $data->id))){echo 'class="menu-left"';} ?>>
        <a href="<?php echo Func::getFullURL($siteData, '/shopoperationstock/index', array(), array('is_public_ignore' => 1, 'type' => $data->id, 'is_group' => 0)); ?>"><i class="fa fa-circle-o text-light-blue"></i>
            <span><?php echo $data->values['name'];?> филиалы</span>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopreport/branch/operationstock?type='.$data->id, $siteData))){ ?>
    <li <?php if(!(($siteData->controllerName == 'shopreport')
        && (Request_RequestParams::getParamInt('type') == $data->id))){echo 'class="menu-left"';} ?>>
        <a href="<?php echo Func::getFullURL($siteData, '/shopreport/branch/operationstock', array(), array('type' => $data->id)); ?>"><i class="fa fa-circle-o text-light-blue"></i>
            <span><?php echo $data->values['name'];?> отчеты</span>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopreport/good/operationstock?type='.$data->id, $siteData))){ ?>
    <li <?php if(!(($siteData->controllerName == 'shopreport')
        && (Request_RequestParams::getParamInt('type') == $data->id))){echo 'class="menu-left"';} ?>>
        <a href="<?php echo Func::getFullURL($siteData, '/shopreport/good/operationstock', array(), array('type' => $data->id)); ?>"><i class="fa fa-circle-o text-light-blue"></i>
            <span>Проданные товары отчеты</span>
        </a>
    </li>
<?php } ?>
<?php echo $data->additionDatas['view::_shop/_table/catalog/menu/one/child']; ?>