<tr>
    <td>
        <?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>
    </td>
    <td>
        <?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['from_at']); ?>
        <br><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['to_at']); ?>
    </td>
    <td><?php echo $data->getElementValue('shop_courier_id'); ?></td>
    <td>
        <?php echo $data->getElementValue('shop_courier_address_id_from'); ?>
        <br><?php echo $data->getElementValue('shop_courier_address_id_to'); ?>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity_points']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price_point']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['wage']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['distance']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['seconds']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price_km']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['mean_point_distance_km']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['mean_point_second']); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/del', array('id' => 'id'), array('is_undel' => 1), $data->values);  ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
