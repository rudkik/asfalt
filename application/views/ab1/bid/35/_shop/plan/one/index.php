<tr>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo Helpers_DateTime::getTimeByDate($data->values['date_from']); ?></td>
    <td><?php echo Helpers_DateTime::getTimeByDate($data->values['date_to']); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopplan/edit', array('id' => 'id'), array(), $data->values, FALSE, FALSE, TRUE); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopplan/del', array('id' => 'id'), array(), $data->values, FALSE, FALSE, TRUE); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopplan/del', array('id' => 'id'), array('is_undel' => 1), $data->values, FALSE, FALSE, TRUE); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
