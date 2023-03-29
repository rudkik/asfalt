<?php if ((Func::isShopMenu('shopoperation/index?type='.$data->id, $siteData))){ ?>
    <li <?php if(!(($siteData->controllerName == 'shopoperation')
        && (Request_RequestParams::getParamInt('type') == $data->id))){echo 'class="menu-left"';} ?>>
        <a href="<?php echo Func::getFullURL($siteData, '/shopoperation/index', array(), array('is_public_ignore' => 1, 'type' => $data->id, 'is_group' => 0)); ?>"><i class="fa fa-circle-o text-light-blue"></i>
            <span><?php echo $data->values['name'];?></span>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shoptablerubric/index?type='.$data->id, $siteData))){ ?>
    <li <?php if(!(($siteData->controllerName == 'shoptablerubric')
        && (Request_RequestParams::getParamInt('type') == $data->id)
        && (Request_RequestParams::getParamInt('table_id') == Model_Shop_Operation::TABLE_ID))){echo 'class="menu-left"';} ?>>
        <a href="<?php echo Func::getFullURL($siteData, '/shoptablerubric/index', array(), array('is_public_ignore' => 1, 'type' => $data->id, 'table_id' => Model_Shop_Operation::TABLE_ID)); ?>"><i class="fa fa-circle-o text-light-blue"></i>
            <?php echo Func::mb_ucfirst(Arr::path($data->values['form_data'], 'shop_table_rubric.fields_title.title', 'рубрики '.$data->values['name']));?>
        </a>
    </li>
<?php }  ?>
<?php echo $data->additionDatas['view::_shop/_table/catalog/menu/one/child']; ?>