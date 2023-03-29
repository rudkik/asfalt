<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shoptransportmark/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->getElementValue('transport_view_id'); ?></td>
    <td><?php echo $data->getElementValue('transport_type_1c_id'); ?></td>
    <td><?php echo $data->getElementValue('transport_work_id'); ?></td>
    <td><?php echo $data->getElementValue('transport_wage_id'); ?></td>
    <td><?php echo $data->getElementValue('transport_form_payment_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['milage'], true, 2, false); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['fuel_quantity'], true, 3, false); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <?php if ($siteData->operation->getOperationTypeID() == Model_OperationType::ATC_CHIEF){ ?>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shoptransportmark/edit', array('id' => 'id'), array('is_show' => true), $data->values, false, false, true); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
            <?php } else{ ?>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shoptransportmark/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoptransportmark/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoptransportmark/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <?php } ?>
        </ul>
    </td>
</tr>
