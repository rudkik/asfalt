<tr data-action="db-click-edit">
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['created_at']); ?></td>
    <td>
        <?php
        if($data->values['created_at'] == 1){
            echo 'слив вагонов';
        }else{
            echo 'производство материла';
        }
        ?>
    </td>
    <td><?php echo $data->getElementValue('shop_raw_drain_chute_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_raw_storage_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_raw_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_material_storage_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_material_id'); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a data-name="edit" href="<?php echo Func::getFullURL($siteData, '/shoprawstoragedrain/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoprawstoragedrain/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoprawstoragedrain/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
