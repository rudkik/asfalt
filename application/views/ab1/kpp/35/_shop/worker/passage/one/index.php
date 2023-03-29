<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopworkerpassage/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['old_id']; ?></td>
    <td><?php echo $data->values['controller_number']; ?></td>
    <td><?php echo $data->values['ip']; ?></td>
    <td><?php echo $data->values['last_operation']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_connect']); ?></td>
    <td class="text-center"><?php if($data->values['is_car'] == 1){echo 'да';}else{echo 'нет';} ?></td>
    <td class="text-center"><?php if($data->values['is_exit'] == 1){echo 'да';}else{echo 'нет';} ?></td>
    <td class="text-center"><?php if($data->values['is_inside_move'] == 1){echo 'да';}else{echo 'нет';} ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopworkerpassage/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopworkerpassage/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopworkerpassage/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>