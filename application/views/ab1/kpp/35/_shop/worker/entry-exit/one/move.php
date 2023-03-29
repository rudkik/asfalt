<tr>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date_entry']); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date_exit']); ?></td>
    <td><?php echo $data->getElementValue('shop_worker_id') . ' ' . $data->getElementValue('guest_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_department_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_worker_passage_id'); ?></td>
    <td><?php echo $data->getElementValue('exit_shop_worker_passage_id'); ?></td>
    <td class="text-center"><?php if($data->values['is_car'] == 1){echo 'да';}else{echo 'нет';} ?></td>
</tr>
