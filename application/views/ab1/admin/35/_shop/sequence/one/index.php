<tr>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['text']; ?></td>
    <td class="text-right"><?php echo Arr::path($data->additionDatas, 'number', ''); ?></td>
    <td><?php echo $data->getElementValue('shop_id'); ?></td>
    <td><?php echo $data->values['symbol']; ?></td>
    <td class="text-right"><?php echo $data->values['length']; ?></td>
    <td class="text-center">
        <input <?php if ($data->values['is_branch'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" disabled>
    </td>
    <td class="text-center">
        <input <?php if ($data->values['is_cashbox'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" disabled>
    </td>
    <td class="text-center">
        <input <?php if ($data->values['is_product'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" disabled>
    </td>
    <td><?php echo $data->getElementValue('table_id'); ?></td>
    <td><?php echo Arr::path($data->additionDatas, 'sequence_name', ''); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopsequence/edit', array('id' => 'id'), array('sequence' => Arr::path($data->additionDatas, 'sequence_name', '')), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
        </ul>
    </td>
</tr>