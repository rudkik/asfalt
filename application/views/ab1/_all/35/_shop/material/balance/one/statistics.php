<tr>
    <td><?php echo $data->getElementValue('shop_material_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_subdivision_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
</tr>
