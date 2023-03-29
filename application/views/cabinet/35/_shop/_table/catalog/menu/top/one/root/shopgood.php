<?php if ((Func::isShopMenu('shopgood/index?type='.$data->id, $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgood/index?is_public_ignore=1&type=<?php echo $data->id; ?>&is_group=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            <?php echo $data->values['name'];?>
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shopgood/group?type='.$data->id, $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgood/index?is_public_ignore=1&type=<?php echo $data->id; ?>&is_group=1<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            Группы (<?php echo $data->values['name'];?>)
        </a>
    </li>
<?php } ?>
<?php if ((Func::isShopMenu('shoptablerubric/index?type='.$data->id, $siteData))){ ?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablerubric/index?is_public_ignore=1&table_id=<?php echo Model_Shop_Good::TABLE_ID; ?>&type=<?php echo $data->id; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
            <?php echo Func::mb_ucfirst(Arr::path($data->values['form_data'], 'shop_table_rubric.fields_title.title', 'рубрики '.$data->values['name']));?>
        </a>
    </li>
<?php }  ?>
<?php echo $data->additionDatas['view::_shop/_table/catalog/menu/top/one/child']; ?>