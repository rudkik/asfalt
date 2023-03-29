<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopformularaw/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['created_at']); ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['from_at']); ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['to_at']); ?></td>
    <td><?php echo $data->getElementValue('shop_ballast_crusher_id'); ?></td>
    <td><?php echo $data->values['contract_number']; ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['contract_date']); ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopformularaw/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li><a data-action="clone-auto" href="<?php echo Func::getFullURL($siteData, '/shopformularaw/clone', array('id' => 'id'), array(), $data->values); ?>" class="link-black"><i class="fa fa-clone margin-r-5"></i> Повторить</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopformularaw/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopformularaw/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <?php } ?>
        </ul>
    </td>
</tr>