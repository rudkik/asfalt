<?php if (Arr::path($data->values, 'is_all', FALSE) == TRUE){ ?>
    <tr style="font-weight: 700; background-color: #5EC4CD;">
        <td>Всего</td>
        <td class="text-right"><?php echo $data->values['count']; ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['total'], true, 3, false); ?></td>
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
        <td class="text-right"><?php echo $data->values['count']; ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr(Arr::path($data->additionDatas, 'total', 0)); ?></td>
    </tr>
<?php } ?>
