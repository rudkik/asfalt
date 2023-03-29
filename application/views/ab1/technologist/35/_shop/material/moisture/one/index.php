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
    <td class="text-right">
        <a data-id="<?php echo $data->values['id'];?>" href="#" data-action="update-moisture" data-moisture="<?php echo $data->values['moisture'];?>">
            <?php echo Func::getNumberStr($data->values['moisture'], true, 2, false); ?>
        </a>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['density'], true, 2, false); ?></td>
    <td data-id="stock" class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopmaterialmoisture/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopmaterialmoisture/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopmaterialmoisture/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <li><a data-action="calc-stock" href="<?php echo Func::getFullURL($siteData, '/shopmaterialmoisture/calc_quantity', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Пересчитать завоз</a></li>
        </ul>
    </td>
</tr>
