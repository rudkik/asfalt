<tr>
    <td>
        <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index', array(), array('shop_boxcar_train_id' => $data->values['shop_boxcar_train_id'], 'is_in_transit' => true)); ?>">
            <?php echo $data->getElementValue('shop_boxcar_client_id'); ?>
        </a>
    </td>
    <td><?php echo $data->getElementValue('shop_raw_id'); ?></td>
    <td class="text-right"><?php echo $data->values['count']; ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Helpers_DateTime::getDateTimeFormatRus($data->getElementValue('shop_boxcar_train_id', 'date_shipment')); ?></td>
</tr>
