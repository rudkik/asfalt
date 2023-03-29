<tr>
    <td><?php echo $data->getElementValue('shop_company_id'); ?></td>
    <td>
        <?php if(!Func::_empty($data->getElementValue('shop_receive_id', 'date'))){ ?>
            №<a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopreceive/edit', array(), array('id' => $data->values['shop_receive_id'])); ?>" class="text-blue text-sm"><?php echo $data->getElementValue('shop_receive_id', 'number'); ?></a>
            <br><?php echo Helpers_DateTime::getDateFormatRus($data->getElementValue('shop_receive_id', 'date')); ?>
        <?php } ?>
    </td>
    <td><?php echo $data->getElementValue('shop_supplier_id'); ?></td>
    <td>
        <span data-id="receive"><?php echo $data->values['name']; ?></span>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true); ?></td>
    <td>
        <?php if ($data->values['shop_product_id'] > 0){ ?>
            <b><?php echo $data->getElementValue('shop_product_id', 'article'); ?></b>
            <br><span data-id="product"><?php echo $data->getElementValue('shop_product_id'); ?></span>
        <?php } ?>
        <?php if ($data->values['return_shop_receive_id'] > 0){ ?>
            Возврат №<a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopreceive/edit', array(), array('id' => $data->values['return_shop_receive_id'])); ?>" class="text-blue text-sm"><?php echo $data->getElementValue('return_shop_receive_id', 'number'); ?></a>
        <?php } ?>
        <?php if ($data->values['is_expense'] > 0){ ?>
            <span class="text-red">Расход</span>
        <?php } ?>
        <?php if ($data->values['is_store'] > 0){ ?>
            <span class="text-blue">На складе</span>
        <?php } ?>
        <?php if ($data->values['is_return'] > 0){ ?>
            <span class="text-blue">Возврат</span>
        <?php } ?>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity_sales'], true); ?></td>
</tr>