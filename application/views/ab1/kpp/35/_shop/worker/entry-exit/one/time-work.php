<tr>
    <td><?php echo $data->getElementValue('shop_worker_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_department_id'); ?></td>
    <td class="text-right"><?php echo Helpers_DateTime::secondToTime($data->values['late_for']); ?></td>
    <td class="text-right"><?php echo Helpers_DateTime::secondToTime($data->values['early_exit']); ?></td>
    <td class="text-right"><?php echo Helpers_DateTime::secondToTime($data->values['time_work']); ?></td>
</tr>
