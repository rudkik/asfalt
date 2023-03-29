<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shoptransport/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <td><?php echo $data->values['name']; ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <?php if ($siteData->operation->getOperationTypeID() == Model_OperationType::ATC_CHIEF){ ?>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shoptransportfueldepartment/edit', array('id' => 'id'), array('is_show' => true), $data->values, false, false, true); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
            <?php } else{ ?>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shoptransportfueldepartment/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoptransportfueldepartment/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoptransportfueldepartment/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <?php } ?>
        </ul>
    </td>
</tr>
