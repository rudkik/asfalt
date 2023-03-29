<tr>
    <td><?php echo $data->id; ?></td>
    <td><img data-action="modal-image" src="<?php echo Helpers_Image::getPhotoPath(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.image_path', ''), 68, 52); ?>"></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.name', ''); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_operation_id.name', ''); ?></td>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['price']); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopgoodtooperation/edit_good', array(), array('id' => $data->values['shop_good_id']), $data->values); ?>" class="link-blue text-sm"><i class="fa fa-edit margin-r-5"></i> Изменить цены товара</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopgoodtooperation/edit_operation', array(), array('id' => $data->values['shop_operation_id']), $data->values); ?>" class="link-blue text-sm"><i class="fa fa-edit margin-r-5"></i> Изменить цены оператора</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopgoodtooperation/del', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopgoodtooperation/del', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
