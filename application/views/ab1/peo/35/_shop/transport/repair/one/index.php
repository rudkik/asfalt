<tr>
    <td>
        <?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_transport_id');?>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_transport_id', 'number');?>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_transport_driver_id');?>
    </td>
    <td>
        <?php echo $data->getElementValue('create_user_id'); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['hours'], true); ?>
    </td>
</tr>