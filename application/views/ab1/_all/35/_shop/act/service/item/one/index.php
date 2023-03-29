<tr>
    <td><?php echo $data->values['id']; ?></td>
    <td><?php echo $data->values['ticket']; ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->getElementValue('shop_delivery_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['delivery_km'], TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['delivery_quantity'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['delivery_amount'], TRUE, 2, FALSE); ?></td>
    <?php if(Request_RequestParams::getParamBoolean('is_all')){ ?>
    <td>
        <ul class="list-inline tr-button">
            <?php if(Arr::path($data->additionDatas, 'is_piece', false)){ ?>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shoppiece/edit', array(), array('id' => Arr::path($data->values, 'shop_piece_id', 0)), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Подробно</a></li>
            <?php }else{ ?>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shopcar/edit', array(), array('id' => Arr::path($data->values, 'shop_car_id', 0)), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Подробно</a></li>
            <?php } ?>
        </ul>
    </td>
    <?php } ?>
</tr>