<tr>
    <td class="text-right">#index#</td>
    <td>
        <?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->getElementValue('shop_car_id', 'weighted_exit_at')); ?>
        <?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->getElementValue('shop_piece_id', 'created_at')); ?>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_car_id'); ?>
        <?php echo $data->getElementValue('shop_piece_id'); ?>
    </td>
    <td><?php echo $data->getElementValue('shop_product_id'); ?></td>
    <td class="text-right" <?php if($data->getElementValue('shop_car_id', 'is_test')){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'], TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <?php if(key_exists('shop_car_id', $data->values)){ ?>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopcar/edit', array(), array('id' => $data->values['shop_car_id'], 'shop_branch_id' => $data->values['shop_id']), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Талон</a></li>
            <?php }elseif(key_exists('shop_piece_id', $data->values)){ ?>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shoppiece/edit', array(), array('id' => $data->values['shop_piece_id'], 'shop_branch_id' => $data->values['shop_id']), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Талон</a></li>
            <?php } ?>
        </ul>
    </td>
</tr>
