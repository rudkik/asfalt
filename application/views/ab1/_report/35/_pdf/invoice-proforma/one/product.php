<tr>
    <td style="text-align: right;">#index#</td>
    <td><?php echo $data->getElementValue('shop_product_id', 'name_1c'); ?></td>
    <td style="text-align: right;"><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false);?></td>
    <td><?php echo $data->getElementValue('shop_product_id', 'unit'); ?></td>
    <td style="text-align: right;"><?php echo Func::getNumberStr($data->values['price'], true, 2, false);?></td>
    <td style="text-align: right;"><?php echo Func::getNumberStr($data->values['amount'], true, 2, false);?></td>
</tr>