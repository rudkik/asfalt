<tr>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['weighted_at']); ?></td>
    <td><?php echo $data->getElementValue('shop_storage_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_product_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td><?php echo $data->getElementValue('shop_turn_place_id'); ?></td>
    <td><?php echo $data->getElementValue('asu_operation_id'); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopproductstorage/edit', array('id' => 'id'), array('is_show' => true), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
        </ul>
    </td>
</tr>
