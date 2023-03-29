<tr>
    <td>
        <b data-id="name"><?php echo $data->values['old_id']; ?></b>
        <br><a target="_blank" class="text-blue" href="https://kaspi.kz/merchantcabinet/#/orders/details/<?php echo $data->values['old_id']; ?>"><?php echo $data->getElementValue('shop_source_id'); ?></a>
        <br><?php echo $data->getElementValue('shop_company_id'); ?>
    </td>
    <td>
        <?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['approve_source_at']); ?>
        <br><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['delivery_plan_at']); ?>
        <br><b><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['delivery_at']); ?></b>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_bill_state_source_id'); ?>
        <br><?php echo $data->getElementValue('shop_bill_status_source_id'); ?>
        <br><?php echo $data->getElementValue('shop_bill_status_id'); ?>
        <br><?php echo $data->getElementValue('shop_bill_cancel_type_id'); ?>
    </td>
    <td>
        <a class="text-blue" href="tel:<?php echo $data->getElementValue('shop_bill_buyer_id', 'phone'); ?>"><?php echo $data->getElementValue('shop_bill_buyer_id', 'phone'); ?></a>
        <br><?php echo $data->values['buyer']; ?>
        <br><?php echo $data->values['delivery_address']; ?>
    </td>
    <td>
        <p style="margin-bottom: 5px"><b><?php echo str_replace("\r\n", '<br>', $data->values['text']); ?></b></p>
        <?php echo str_replace("\r\n", '<br>', $data->values['products']); ?>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_bill_payment_type_id'); ?>
        <br><?php echo $data->getElementValue('shop_bill_delivery_type_id'); ?>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], true); ?></td>
    <td>
        <?php echo $data->getElementValue('shop_courier_id'); ?>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a class="text-red" data-action="set-courier" href="<?php echo Func::getFullURL($siteData, '/shopbill/save', array('id' => 'id'), array(), $data->values); ?>" class="link-blue">Назначить курьера</a></li>
        </ul>
    </td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopbill/edit', array('id' => 'id'), array(), $data->values); ?>" class="text-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
        </ul>
    </td>
</tr>
