<?php $updatedAt = Request_RequestParams::getParamDateTime('_updated_at'); ?>
<tr <?php if($updatedAt != null && strtotime($updatedAt) <= strtotime($data->values['updated_at'])){ ?>class="blink tr-red"<?php } ?> <?php if ($data->values['guest_id'] != 0) {echo 'class="tr-green"'; }?><?php if ($data->values['late_for'] != 0) {echo 'class="tr-red"'; }?><?php if ($data->values['early_exit'] != 0) {echo 'class="tr-yellow"'; }?>>
    <td class="text-center">
        <input <?php if ($data->values['is_exit'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" disabled>
    </td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date_entry']); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date_exit']); ?></td>
    <td><?php echo $data->values['name'] . ' ' . $data->getElementValue('guest_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_department_id'); ?></td>
    <td class="text-right"><?php echo $data->values['late_for']; ?></td>
    <td class="text-right"><?php echo $data->values['early_exit']; ?></td>
    <td><?php echo $data->getElementValue('shop_worker_passage_id'); ?></td>
    <td><?php echo $data->getElementValue('exit_shop_worker_passage_id'); ?></td>
    <td class="text-center"><?php if($data->values['is_car'] == 1){echo 'да';}else{echo 'нет';} ?></td>

</tr>
