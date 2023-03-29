<?php if ($data->values['shop_bill_item_status_id'] == Model_AutoPart_Shop_Bill_Item_Status::STATUS_TO_BOOK + 100) { ?>
    <tr class="text-right">
        <td>#index#</td>
        <td><?php echo $data->getElementValue('shop_supplier_address_id'); ?></td>
        <td>поставщик </td>
        <td><b><?php echo $data->values['text']; ?></b></td>
        <td>
            <?php if ($data->getElementValue('shop_supplier_address_id', 'latitude') == 0
                || $data->getElementValue('shop_supplier_address_id', 'longitude') == 0) { ?>
                <b class="text-red">не удалось разместить на карте</b>
            <?php } ?>
        </td>
    </tr>
<?php }else{ ?>
    <tr>
        <td class="text-right">#index#</td>
        <td>
            <?php if ($data->getElementValue('shop_other_address_id', 'id') > 0) { ?>
                <span style="text-decoration: line-through;"><?php echo $data->getElementValue('shop_bill_delivery_address_id'); ?></span>
                <br><b><?php echo $data->getElementValue('shop_other_address_id'); ?></b>
            <?php }else{ ?>
                <?php echo $data->getElementValue('shop_bill_delivery_address_id'); ?>
            <?php } ?>
        </td>
        <td>
            заказ №<b class="text-blue"><?php echo $data->values['shop_bill_id']; ?></b>
            <br><b><?php echo $data->getElementValue('shop_bill_item_status_id'); ?></b>
        </td>
        <td>
            <b><?php echo $data->getElementValue('shop_supplier_id'); ?></b>
            <br><?php echo $data->getElementValue('shop_product_id'); ?>
        </td>
        <td><b><?php echo $data->values['text']; ?></b></td>
        <td>
            <?php if ($data->getElementValue('shop_bill_delivery_address_id', 'latitude') == 0
                || $data->getElementValue('shop_bill_delivery_address_id', 'longitude') == 0) { ?>
                <b class="text-red">не удалось разместить на карте</b>
            <?php } ?>
        </td>
    </tr>
<?php } ?>