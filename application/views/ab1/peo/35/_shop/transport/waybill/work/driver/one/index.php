<tr>
    <td>
        <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/edit', ['id' => 'shop_transport_waybill_id'], ['is_show' => true], $data->values); ?>">
            <?php echo $data->getElementValue('shop_transport_waybill_id', 'number');?>
        </a>
    </td>
    <td>
        <?php echo Helpers_DateTime::getDateFormatRus($data->getElementValue('shop_transport_waybill_id', 'date')); ?>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_transport_id');?>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_transport_id', 'number');?>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_transport_work_id');?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?>
    </td>
</tr>