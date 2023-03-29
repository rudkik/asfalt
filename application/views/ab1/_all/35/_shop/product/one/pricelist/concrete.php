<tr class="bg-blue">
    <td colspan="5" class="text-center"><?php echo $data->values['name']; ?></td>
</tr>
<?php foreach ($data->values['data'] as $product){ ?>
<tr>
    <td><?php echo $product['name']; ?></td>
    <td class="text-right"><?php echo $product['price']; ?></td>
    <td class="text-center">
        <?php echo Helpers_DateTime::getDateFormatRus($product['from_at']); ?>
    </td>
</tr>
<?php } ?>