<tr data-action="db-click-edit">
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['created_at']); ?></td>
    <td><?php echo $data->getElementValue('shop_raw_storage_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_raw_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['meter'], true, 2, false); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a data-name="edit" href="<?php echo Func::getFullURL($siteData, '/shoprawstoragemetering/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoprawstoragemetering/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoprawstoragemetering/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
