<?php if (Arr::path($data->values, 'is_all', FALSE) == TRUE){ ?>
    <tr style="font-weight: 700; background-color: #5EC4CD;">
        <td>Всего</td>
        <td><?php echo $data->values['count']; ?></td>
        <td><?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?> т</td>
    </tr>
<?php }else{ ?>
    <tr>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_turn_place_id.name', ''); ?></td>
        <td><?php echo $data->values['count']; ?></td>
        <td><?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?> т</td>
    </tr>
<?php } ?>
