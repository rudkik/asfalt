<?php for($i = 1; $i <= Model_Shop_Table_Param::PARAMS_COUNT; $i++){ ?>
    <?php if (Func::isShopMenu('shopcar/table/param_'.$i.'_int?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Func::getNumberStr($data->values['param_'.$i.'_int'], TRUE, 0); ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopcar/table/param_'.$i.'_float?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Func::getNumberStr($data->values['param_'.$i.'_float'], TRUE, 0); ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopcar/table/param_'.$i.'_str?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo $data->values['param_'.$i.'_str']; ?></td>
    <?php } ?>
<?php } ?>