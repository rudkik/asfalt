<tr>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->getElementValue('shop_piece_id', 'created_at')); ?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_piece_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_product_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></td>
    <td><?php echo $data->getElementValue('shop_formula_product_id'); ?></td>
</tr>
