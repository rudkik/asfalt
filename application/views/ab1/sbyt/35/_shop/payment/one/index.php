<tr>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_client_contract_id', 'number', 'без договора'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shoppayment/edit', array('id' => 'id'), array('is_show' => 1), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
        </ul>
    </td>
</tr>
