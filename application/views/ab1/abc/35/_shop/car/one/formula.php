<tr>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name', ''); ?></td>
    <td><?php echo $data->getElementValue('shop_formula_product_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['count'], true, 0, false); ?></td>
</tr>
