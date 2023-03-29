<tr id="<?php echo $data->id; ?>" data-name="<?php echo $data->values['name'];?>"
    data-type="<?php echo $data->values['type'];?>"
    data-tarra="<?php echo $data->values['tarra'];?>"
    data-quantity="<?php echo $data->values['quantity'];?>"
    data-driver="<?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_driver_id.name', ''), ENT_QUOTES);?>"
    data-is_not_overload="<?php echo Arr::path($data->values['options'], 'is_not_overload', '0');?>"
    data-client="<?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES);?>"
    data-packed-tare="<?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.tare', ''), ENT_QUOTES);?>"
    data-coefficient-weight-quantity="<?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.coefficient_weight_quantity', ''), ENT_QUOTES);?>"
    data-is-packed="<?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.is_packed', ''), ENT_QUOTES);?>"
    <?php if ($data->values['shop_turn_id'] == Model_Ab1_Shop_Turn::TURN_CASH_EXIT) {?>
    style="background-color: #cbf7ab;"
    <?php }?>>
    <td><img data-action="show-big" data-id="<?php echo $data->id; ?>" data-type="<?php echo Model_Ab1_Shop_Car::TABLE_ID; ?>" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>"></td>
    <td class="text-number"><?php echo $data->values['name'];?></td>
    <td <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo $data->values['tarra'];?></td>
    <td><button onclick="sendBruttoForm(<?php echo $data->id; ?>);" class="btn bg-navy btn-flat">Взвесить</button></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name', ''); ?></td>
    <td><?php echo $data->values['number'];?></td>
</tr>
