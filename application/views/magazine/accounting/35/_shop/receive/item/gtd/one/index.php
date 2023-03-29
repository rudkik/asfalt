<tr>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td>
        <?php echo $data->getElementValue('shop_supplier_id'); ?>
        <br><?php echo $data->getElementValue('shop_supplier_id', 'bin'); ?>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_product_id'); ?>
        <br><?php echo $data->getElementValue('shop_product_id', 'barcode'); ?>
    </td>
    <td><?php echo $data->values['tru_origin_code']; ?></td>
    <td><?php echo $data->values['product_declaration']; ?></td>
    <td><?php echo $data->values['product_number_in_declaration']; ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'], TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity_invoice'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity_balance'], TRUE, 3, FALSE); ?></td>
</tr>
