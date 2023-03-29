<tr>
    <td><?php echo $data->getElementValue('shop_car_id', 'id', $data->getElementValue('shop_piece_id', 'id')); ?></td>
    <td><?php echo $data->getElementValue('shop_car_id', 'ticket', $data->getElementValue('shop_piece_id', 'ticket')); ?></td>
    <td><?php echo $data->getElementValue('shop_car_id', 'name', $data->getElementValue('shop_piece_id')); ?></td>
    <td><?php echo $data->getElementValue('shop_product_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'], TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td>
        <ul class="list-inline tr-button">
            <?php if($data->values['shop_car_id'] > 0){ ?>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shopcar/edit', array(), array('id' => Arr::path($data->values, 'shop_car_id', 0)), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Талон</a></li>
            <?php }else{ ?>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shoppiece/edit', array(), array('id' => Arr::path($data->values, 'shop_piece_id', 0)), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Талон</a></li>
            <?php } ?>
        </ul>
    </td>
</tr>