<tr>
    <td>
        <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index', array(), array('shop_boxcar_train_id' => $data->values['shop_boxcar_train_id'])); ?>">
            <?php echo $data->getElementValue('shop_boxcar_client_id'); ?>
        </a>
    </td>
    <td><?php echo $data->getElementValue('shop_raw_id'); ?></td>
    <td class="text-right"><?php echo $data->values['count']; ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date_arrival']); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_drain_from']); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_drain_to']); ?></td>
</tr>
