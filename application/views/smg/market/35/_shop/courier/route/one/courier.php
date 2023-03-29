<tr>
    <td>
        <a href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/show', array('id' => 'id'), array(), $data->values); ?>" class="text-blue">
            <?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>
        </a>
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
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount']); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/show', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Маршрут</a></li>
        </ul>
    </td>
</tr>
