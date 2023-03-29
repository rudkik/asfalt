<tr class="bg-blue">
    <td colspan="6" class="text-center"><?php echo $data->values['name']; ?></td>
</tr>
<?php foreach ($data->values['data'] as $product){ ?>
<tr>
    <td><?php echo $product['name']; ?></td>
    <td class="text-right"><?php echo $product['price']; ?></td>
    <td class="text-right"><?php echo $product['options']['weighted']; ?></td>
    <td class="text-right">
        <?php if(!empty($product['options']['length'])){ ?>
            <?php echo Func::getNumberStr($product['options']['length'], true, 2, false); ?>x<?php echo Func::getNumberStr($product['options']['width'], true, 2, false); ?>x<?php echo Func::getNumberStr($product['options']['height'], true, 2, false); ?>
        <?php } ?>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($product['options']['volume'], true, 3, false); ?></td>
    <td class="text-center">
        <?php echo Helpers_DateTime::getDateFormatRus($product['from_at']); ?>
    </td>
</tr>
<?php } ?>