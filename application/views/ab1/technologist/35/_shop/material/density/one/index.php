<tr>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?></td>
    <td>
        <?php echo $data->getElementValue('shop_daughter_id'); ?>
        <?php echo $data->getElementValue('shop_branch_daughter_id'); ?>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_material_id'); ?>
        <?php echo $data->getElementValue('shop_raw_id'); ?>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['density'], true, 2, false); ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date_from']); ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date_to']); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopmaterialdensity/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopmaterialdensity/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopmaterialdensity/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <li><a data-action="calc-stock" href="<?php echo Func::getFullURL($siteData, '/shopmaterialdensity/calc_quantity', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Пересчитать завоз</a></li>
        </ul>
    </td>
</tr>
