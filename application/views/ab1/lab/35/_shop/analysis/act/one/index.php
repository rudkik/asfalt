<tr>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date']); ?></td>
    <td><?php echo $data->getElementValue('shop_analysis_type_id'); ?></td>
    <td>
        <?php
        if($data->values['shop_material_id'] > 0) {
            echo $data->getElementValue('shop_material_id');
        }elseif($data->values['shop_product_id'] > 0) {
            echo $data->getElementValue('shop_product_id');
        }elseif($data->values['shop_raw_id'] > 0) {
            echo $data->getElementValue('shop_raw_id');
        }
        ?>
    </td>
    <td><?php echo $data->getElementValue('shop_analysis_place_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_worker_id'); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopanalysisact/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopanalysisact/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopanalysisact/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
