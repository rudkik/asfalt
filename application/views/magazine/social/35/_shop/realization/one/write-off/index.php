<tr>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td><?php echo $data->getElementValue('shop_write_off_type_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shoprealization/edit', array('id' => 'id', 'is_special' => 'is_special'), array('is_show' => TRUE), $data->values); ?>" class="link-blue"><i class="fa fa-list-alt margin-r-5"></i> Просмотр</a></li>
        </ul>
    </td>
</tr>
