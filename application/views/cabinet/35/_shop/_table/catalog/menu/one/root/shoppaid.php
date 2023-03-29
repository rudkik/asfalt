<?php if ((Func::isShopMenu('shoppaid/index?type='.$data->id, $siteData))){ ?>
    <li <?php if(!(($siteData->controllerName == 'shoppaid')
        && (Request_RequestParams::getParamInt('type') == $data->id))){echo 'class="menu-left"';} ?>>
        <a href="<?php echo Func::getFullURL($siteData, '/shoppaid/index', array(), array('is_public_ignore' => 1, 'type' => $data->id, 'is_group' => 0)); ?>"><i class="fa fa-circle-o text-light-blue"></i>
            <span><?php echo $data->values['name'];?></span>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shoptablerubric/index?type='.$data->id, $siteData))){ ?>
    <li <?php if(!(($siteData->controllerName == 'shoptablerubric')
        && (Request_RequestParams::getParamInt('type') == $data->id)
        && (Request_RequestParams::getParamInt('table_id') == Model_Shop_Question::TABLE_ID))){echo 'class="menu-left"';} ?>>
        <a href="<?php echo Func::getFullURL($siteData, '/shoptablerubric/index', array(), array('is_public_ignore' => 1, 'type' => $data->id, 'table_id' => Model_Shop_Question::TABLE_ID)); ?>"><i class="fa fa-circle-o text-light-blue"></i>
            <?php echo Func::mb_ucfirst(Arr::path($data->values['form_data'], 'shop_table_rubric.fields_title.title', 'рубрики '.$data->values['name']));?>
        </a>
    </li>
<?php }  ?>
<?php if ((Func::isShopMenu('shopreport/branch/paid?type='.$data->id, $siteData))){ ?>
    <li <?php if(!(($siteData->controllerName == 'shopreport')
        && (Request_RequestParams::getParamInt('type') == $data->id))){echo 'class="menu-left"';} ?>>
        <a href="<?php echo Func::getFullURL($siteData, '/shopreport/branch/paid', array(), array('type' => $data->id)); ?>"><i class="fa fa-circle-o text-light-blue"></i>
            <span><?php echo $data->values['name'];?> отчеты</span>
        </a>
    </li>
<?php } ?>
