<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo 'value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shoprubricsource/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <td>
        <a class="text-blue" href="<?php echo Func::getFullURL($siteData, '/shoprubricsource/index', array(), array('root_id' => $data->values['id']));?>">
            <?php echo $data->values['name']; ?>
        </a>
    </td>
    <td><?php echo $data->getElementValue('shop_source_id'); ?></td>
    <td><?php echo $data->getElementValue('root_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['markup'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['commission'], true); ?></td>
    <td class="text-center">
        <input name="set-is-public" data-field="is_sale" <?php if ($data->values['is_sale'] == 1) { echo 'value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shoprubricsource/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['commission_sale'], true); ?>
    </td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shoprubricsource/edit', array('id' => 'id'), array(), $data->values); ?>" class="text-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoprubricsource/del', array('id' => 'id'), array(), $data->values); ?>" class="text-red text-sm"><i class="fa fa-times margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoprubricsource/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="text-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
