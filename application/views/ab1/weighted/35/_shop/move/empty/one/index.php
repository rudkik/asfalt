<tr <?php if($data->values['quantity'] > 0.1){?>class="tr-red" <?php }?>>
    <td><img data-action="show-big" data-id="<?php echo $data->id; ?>" data-type="<?php echo Model_Ab1_Shop_Move_Empty::TABLE_ID; ?>" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>"></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['weighted_exit_at']); ?></td>
    <td><?php echo $data->getElementValue('shop_move_place_id'); ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->getElementValue('shop_driver_id.name'); ?></td>
    <td class="text-right" <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo Func::getNumberStr($data->values['tarra'], true, 3, false); ?></td>
    <td class="text-right" <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></td>
    <?php if($siteData->operation->getIsAdmin()){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.weighted_exit_operation_id.name', ''); ?></td>
    <?php } ?>
    <?php if($siteData->operation->getIsAdmin()){ ?>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopmoveempty/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
        </ul>
    </td>
    <?php } ?>
</tr>
