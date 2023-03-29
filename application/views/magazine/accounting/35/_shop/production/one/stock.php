<tr>
    <td class="relative">
        <i data-action="load-photo-click" class="fa fa-fw fa-camera" style="font-size: 20px; cursor: pointer;"></i>
        <i data-id="img-status" class="fa fa-fw fa-check is-image" <?php if(!Func::_empty($data->getElementValue('shop_production_id', 'image_path'))){echo 'data-img="true"';} ?>></i>
        <input data-id="<?php echo $data->values['id']; ?>" data-action="load-photo" data-id="file" type="file" multiple="multiple" accept=".txt,image/*" style="display: none">
    </td>
    <td>
        <a target="_blank" href="/accounting/shopproduction/history?shop_production_id=<?php echo $data->values['id']; ?>">
            <?php echo $data->values['name']; ?>
        </a>
        <br><?php echo $data->values['barcode']; ?>
    </td>
    <td><?php echo $data->getElementValue('shop_production_rubric_id'); ?></td>
    <td><?php echo $data->getElementValue('unit_id'); ?></td>
    <td class="text-right" data-id="stock"><?php echo Func::getNumberStr($data->getElementValue('shop_production_stock_id', 'quantity_balance'), TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'], TRUE, 2, FALSE); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopproduction/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopproduction/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopproduction/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <li><a data-action="calc-stock" href="<?php echo Func::getFullURL($siteData, '/shopproduction/calc_stocks', array(), array('shop_production_id' => $data->id), $data->values); ?>" class="link-blue"><i class="fa fa-calculator margin-r-5"></i> Пересчитать остатки</a></li>
        </ul>
    </td>
</tr>
