<tr>
    <td data-id="index" class="text-right">#index#</td>
    <td>
        <span><?php echo $data->getElementValue('shop_production_id'); ?></span>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'], TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
</tr>