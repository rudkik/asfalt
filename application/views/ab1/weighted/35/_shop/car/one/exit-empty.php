<tr id="<?php echo $data->id; ?>" data-name="<?php echo $data->values['name'];?>"
    data-type="<?php echo $data->values['type'];?>"
    data-quantity="<?php echo $data->values['quantity'];?>"
    data-is_not_overload="<?php echo Arr::path($data->values['options'], 'is_not_overload', '0');?>"
    data-coefficient-weight-quantity="<?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.coefficient_weight_quantity', ''), ENT_QUOTES);?>"
    data-tarra="<?php echo $data->values['tarra'];?>" data-client="<?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES);?>">
    <td><img data-action="show-big" data-id="<?php echo $data->id; ?>" data-type="<?php echo Model_Ab1_Shop_Car::TABLE_ID; ?>" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>"></td>
    <td class="text-number"><?php echo $data->values['name'];?></td>
    <td <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo Func::getNumberStr($data->values['tarra'], true, 3, false);?></td>
    <td><button onclick="sendBruttoForm(<?php echo $data->id; ?>);" class="btn bg-navy btn-flat">Пустой</button></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name', ''); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_turn_place_id.name', ''); ?></td>
    <td>
        <button onclick="showAutoAdd(<?php echo $data->id; ?>, <?php echo $data->values['type']; ?>);" class="btn bg-olive btn-flat" style="margin-bottom: 5px;">Изменить</button>
        <div class="btn-group">
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                <span>Направить </span>
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu" style="right: 0px;left: auto;">
                <?php
                $s = str_replace('#id#', $data->id, $siteData->replaceDatas['view::_shop/turn/place/list/transfer']);
                if ($data->values['type'] == Model_Ab1_Shop_Move_Car::TABLE_ID){
                    $s = str_replace('/shopcar/', '/shopmovecar/', $s);
                }elseif ($data->values['type'] == Model_Ab1_Shop_Defect_Car::TABLE_ID){
                    $s = str_replace('/shopcar/', '/shopdefectcar/', $s);
                }
                echo $s;
                ?>
            </ul>
        </div>
    </td>
</tr>
