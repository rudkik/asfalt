<tr>
    <td>
        <a href="<?php echo Func::getFullURL($siteData, '/shoppreorder/show', array('id' => 'id'), array(), $data->values); ?>" class="text-blue">
            <?php echo $data->getElementValue('shop_supplier_id', 'name'); ?>
        </a>
    </td>
    <td>
        <a href="<?php echo Func::getFullURL($siteData, '/shoppreorder/show', array('id' => 'id'), array(), $data->values); ?>" class="text-blue">
            <?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>
        </a>
    </td>
    <td class="text-right">
        <a href="<?php echo Func::getFullURL($siteData, '/shoppreorder/show', array('id' => 'id'), array(), $data->values); ?>" class="text-blue">
            <?php echo $data->values['number']; ?>
        </a>
    </td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['buy_at']); ?></td>
    <td><?php echo $data->getElementValue('shop_supplier_address_id', 'name'); ?></td>
    <td><?php echo $data->getElementValue('shop_courier_id', 'name'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity']); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shoppreorder/show', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
        </ul>
    </td>
</tr>
