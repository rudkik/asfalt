<?php $updatedAt = Request_RequestParams::getParamDateTime('_updated_at'); ?>
<tr <?php if ($data->values['guest_id'] != 0) {echo 'class="tr-green"'; }?>>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date_entry']); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date_exit']); ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->getElementValue('shop_worker_id') . ' ' . $data->getElementValue('guest_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_worker_passage_id'); ?></td>
    <td class="text-center"><?php if($data->values['shop_worker_entry_exit_id'] > 0){echo 'да';}else{echo 'нет';} ?></td>
</tr>
