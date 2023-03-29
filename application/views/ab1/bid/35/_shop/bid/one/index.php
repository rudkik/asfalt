<tr>
    <td><?php echo Helpers_DateTime::monthToStrRus($data->values['month']).' '.$data->values['year'].' г.'; ?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo Func::getNumberStr($data->values['quantity'], FALSE, 3, FALSE); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopbid/edit', array('id' => 'id'), array(), $data->values, FALSE, FALSE, TRUE); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopbid/del', array('id' => 'id'), array(), $data->values, FALSE, FALSE, TRUE); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopbid/del', array('id' => 'id'), array('is_undel' => 1), $data->values, FALSE, FALSE, TRUE); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
