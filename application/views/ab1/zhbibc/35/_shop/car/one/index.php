<tr>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->getElementValue('shop_driver_id'); ?></td>
    <td>
        <?php
        if($data->values['is_one_attorney'] == 1){
            echo $data->getElementValue('shop_client_attorney_id', 'number');
        }else {
            echo 'множество доверенностей';
        }
        ?>
    </td>
    <td><?php echo $data->getElementValue('shop_product_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_delivery_id', 'name', 'Без доставки'); ?></td>
    <td class="text-right" <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo Func::getNumberStr($data->values['tarra'], true, 3, false); ?></td>
    <td class="text-right" <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></td>
    <td class="text-right <?php
    if ($data->values['shop_client_attorney_id'] > 0){
        $balance = $data->getElementValue('shop_client_attorney_id', 'balance', 0);
        if($balance < -0.0001){
            echo 'text-red';
        }
    }else{
        $balance = $data->getElementValue('shop_client_id', 'balance_cache', 0);
        if($balance < -0.0001){
            echo 'text-red';
        }
    }
    ?>"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_turn_id.name', ''); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopcar/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <?php if($data->values['shop_turn_place_id'] == 0 || $siteData->operation->getIsAdmin()){ ?>
                <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopcar/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopcar/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <?php } ?>
            <?php if ($data->values['is_delete'] == 0 && $data->values['is_public'] == 1) { ?>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shopcar/refusal', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-meh-o margin-r-5"></i> Отказ клиентом</a></li>
            <?php } ?>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li><a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopcar/clone_in_move', array('id' => 'id'), array(), $data->values); ?>" class="link-green text-sm"><i class="fa fa-reply margin-r-5"></i> Скопировать в перемещение</a></li>
            <?php } ?>
        </ul>
    </td>
</tr>
