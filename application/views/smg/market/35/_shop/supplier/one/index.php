<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopsupplier/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <td><?php echo $data->values['bin']; ?></td>
    <td><?php echo $data->values['name']; ?> <br><?php echo $data->values['name_organization']; ?></td>
    <td><?php echo $data->values['phone']; ?></td>
    <td><?php echo $data->values['bank_name']; ?> <br> <?php echo $data->values['bank_number']; ?></td>
    <td><?php echo $data->values['director_position']; ?> <br> <?php echo $data->values['director_name']; ?></td>
    <td><?php echo $data->values['legal_address']; ?></td>
    <td><?php echo $data->values['post_address']; ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopsupplier/edit', array('id' => 'id'), array(), $data->values); ?>" class="text-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopsupplier/del', array('id' => 'id'), array(), $data->values); ?>" class="text-red text-sm"><i class="fa fa-times margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopsupplier/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="text-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>