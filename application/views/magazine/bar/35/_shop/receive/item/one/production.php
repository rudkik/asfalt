<tr data-barcode="<?php echo $data->getElementValue('shop_product_id', 'barcode'); ?>" data-action="tr">
    <td data-id="index" class="text-right">$index$</td>
    <td>
        <a target="_blank" href="/bar/shopproduct/edit?id=<?php echo $data->values['shop_product_id']; ?>"><?php echo $data->getElementValue('shop_product_id'); ?></a>
        <br><span data-id="barcode"><?php echo $data->getElementValue('shop_product_id', 'barcode'); ?></span>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'], TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td>
        <a target="_blank" href="/bar/shopproduction/edit?id=<?php echo $data->getElementValue('shop_production_id', 'id'); ?>"><?php echo $data->getElementValue('shop_production_id'); ?></a>
        <br><span data-id="barcode"><?php echo $data->getElementValue('shop_production_id', 'barcode'); ?></span>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->getElementValue('shop_production_id', 'price'), TRUE, 2, FALSE); ?></td>
    <td class="text-right">
        <input data-action="save-db" name="coefficient" type="text"  class="form-control"
               value="<?php echo $data->getElementValue('shop_production_id', 'coefficient'); ?>"
               data-url="<?php echo Func::getFullURL($siteData, '/shopproduction/save_coefficient', array(), array('id' => $data->getElementValue('shop_production_id', 'id')), $data->values); ?>">
    </td>
</tr>