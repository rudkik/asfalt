<tr data-action="db-click-edit">
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date_from']); ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date_to']); ?></td>
    <td><?php echo $data->getElementValue('shop_product_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_rubric_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_partner_id'); ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['text']; ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['cost'], TRUE, 2, FALSE); ?></td>
    <td><?php echo $data->getElementValue('shop_result_id'); ?></td>
    <td class="text-right"><?php echo $data->values['mbc']; ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a data-name="edit" href="<?php echo Func::getFullURL($siteData, '/shoptask/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li><a data-action="clone-auto" href="<?php echo Func::getFullURL($siteData, '/shoptask/clone', array('id' => 'id'), array(), $data->values); ?>" class="link-black"><i class="fa fa-clone margin-r-5"></i> Дублировать</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoptask/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoptask/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
