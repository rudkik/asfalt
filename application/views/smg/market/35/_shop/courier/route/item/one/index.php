<tr>
    <td class="text-right">#index#</td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['from_at']); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['to_at']); ?></td>
    <td>
        <?php if ($data->values['shop_supplier_id'] > 0) { ?>
            <?php echo $data->getElementValue('shop_supplier_id'); ?>
        <?php } ?>
        <?php if ($data->values['shop_bill_id'] > 0) { ?>
            <?php echo $data->getElementValue('shop_bill_buyer_id'); ?>
        <?php } ?>
    </td>
    <td>
        <?php if ($data->values['shop_bill_delivery_address_id'] > 0) { ?>
            <?php echo $data->getElementValue('shop_bill_delivery_address_id'); ?>
        <?php }elseif ($data->values['shop_supplier_address_id'] > 0) { ?>
            <?php echo $data->getElementValue('shop_supplier_address_id'); ?>
        <?php }elseif ($data->values['shop_other_address_id'] > 0) { ?>
            <?php echo $data->getElementValue('shop_other_address_id'); ?>
        <?php } ?>
    </td>
    <td>
        <?php if ($data->values['shop_pre_order_id'] > 0) { ?>
            Закуп №<a href="<?php echo Func::getFullURL($siteData, '/shoppreorder/edit', array('id' => 'shop_pre_order_id'), array(), $data->values); ?>" class="link-blue text-sm"><?php echo $data->getElementValue('shop_pre_order_id', 'number'); ?></a><br>
        <?php } ?>
        <?php if ($data->values['shop_bill_id'] > 0) { ?>
            Заказ №<a href="<?php echo Func::getFullURL($siteData, '/shopbill/courier', array('id' => 'shop_bill_id'), array(), $data->values); ?>" class="link-blue text-sm"><?php echo $data->getElementValue('shop_bill_id', 'old_id'); ?></a><br>
        <?php } ?>
        <?php if ($data->values['shop_bill_return_id'] > 0) { ?>
            Возврат №<a href="<?php echo Func::getFullURL($siteData, '/shopbillreturn/courier', array('id' => 'shop_bill_return_id'), array(), $data->values); ?>" class="link-blue text-sm"><?php echo $data->getElementValue('shop_bill_return_id', 'old_id'); ?></a><br>
        <?php } ?>
    </td>
    <td class="text-right"><?php echo Func::secondToTimeStrRus($data->values['seconds']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['distance'], true); ?></td>
</tr>
