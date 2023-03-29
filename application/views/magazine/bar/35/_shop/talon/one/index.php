<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shoptalon/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <td><?php echo Helpers_DateTime::getDateMonthAndYearRus($data->values['date']); ?></td>
    <td><?php echo $data->getElementValue('shop_worker_id'); ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['validity_from']); ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['validity_to']); ?></td>
    <td class="text-right"><?php echo $data->values['quantity']; ?></td>
    <td class="text-right"><?php echo $data->values['quantity_spent']; ?></td>
    <td class="text-right"><?php echo $data->values['quantity_balance']; ?></td>
</tr>
