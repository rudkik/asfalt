<?php if (Arr::path($data->values, 'is_all', FALSE) == TRUE){ ?>
    <tr style="font-weight: 700; background-color: #5EC4CD;">
        <td>Всего</td>
        <td><?php echo $data->values['count']; ?></td>
        <td><?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?> т</td>
    </tr>
<?php }else{ ?>
    <tr>
        <td><a href="<?php
            $arr = array(
                'shop_turn_place_id' => $data->values['shop_turn_place_id'],
                'shop_branch_id' => $siteData->shopID,
            );
            echo Func::getFullURL($siteData, '/shopcar/asu_cars', array(), $arr);
            ?>"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_turn_place_id.name', ''); ?></a></td>
        <td><?php echo $data->values['count']; ?></td>
        <td><?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?></td>
    </tr>
<?php } ?>
