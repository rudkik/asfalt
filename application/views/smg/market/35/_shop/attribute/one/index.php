<tr>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['text']; ?></td>
    <td><?php echo $data->getElementValue('shop_product_id', 'name'); ?></td>
    <td><?php echo $data->getElementValue('shop_product_attribute_type_id', 'name'); ?></td>
    <td><?php echo $data->getElementValue('shop_product_attribute_rubric_id', 'name'); ?></td>
</tr>
