<tr>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?></td>
    <td><?php echo $data->getElementValue('shop_raw_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_ballast_crusher_id'); ?></td>
    <td><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shoprawmaterial/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shoprawmaterial/clone', array('id' => 'id'), array(), $data->values); ?>" class="link-black"><i class="fa fa-clone margin-r-5"></i> Повторить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoprawmaterial/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoprawmaterial/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
