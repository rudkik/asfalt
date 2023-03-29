<tr>
    <td class="text-right">#index#</td>
    <td><?php echo $data->getElementValue('transport_work_id'); ?></td>
    <td><?php echo $data->getElementValue('transport_view_id'); ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['number']; ?></td>
    <td class="text-center">
        <input <?php if ($data->values['is_trailer'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" disabled style="width: 24px;">
    </td>
    <td><?php echo $data->getElementValue('shop_transport_driver_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_transport_fuel_storage_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['milage'], true, 0); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['fuel_quantity'], true, 3, false); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/director_index', [], array('shop_transport_id' => $data->values['id'], 'date_from_equally' => Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')))); ?>" class="link-blue">Путевые листы</a></li>
        </ul>
    </td>
</tr>
