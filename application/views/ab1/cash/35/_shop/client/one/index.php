<tr>
    <td><?php echo $data->values['old_id']; ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['bin']; ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['balance_cache'],TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['balance'],TRUE, 2, FALSE); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopclient/edit', array('id' => 'id'), array('is_show' => true), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopclient/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopclient/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
