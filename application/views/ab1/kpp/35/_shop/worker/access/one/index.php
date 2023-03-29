<tr>
    <td><?php echo $data->getElementValue('shop_card_id','number'); ?></td>
    <td><?php echo $data->getElementValue('shop_worker_id') . ' ' . $data->getElementValue('guest_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_department_id'); ?></td>
    <td><?php if ($data->values['access'] == 1) { echo 'Разрешено'; }else{echo 'Запррещено';} ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopworkeraccess/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopworkeraccess/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopworkeraccess/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
