<tr>
    <td><?php echo $data->getElementValue('shop_bill_id', 'name'); ?></td>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_return'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="?> echo Func::getFullURL($siteData, '/shopbillreturn/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id;?>">
    </td>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_refusal'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="?> echo Func::getFullURL($siteData, '/shopbillreturn/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id;?>">
    </td>
    <td><?php echo $data->getElementValue('shop_bill_return_status_id', 'name'); ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['return_at']); ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['plan_return_at']); ?></td>
    <td><?php echo $data->values['text']; ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopbillreturn/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopbillreturn/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopbillreturn/del', array('id' => 'id'), array('is_undel' => 1), $data->values);  ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
