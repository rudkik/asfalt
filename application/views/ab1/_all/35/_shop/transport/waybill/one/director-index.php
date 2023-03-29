<?php
/** @var MyArray $data */
/** @var SitePageData $siteData */
//print_r($data);die;
?>
<tr>
    <td>
        <input <?php if (!empty($data->values['to_at']) && ($data->values['fuel_quantity_expenses'] > 0)) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" disabled>
    </td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?></td>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['from_at']); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['to_at']); ?></td>
    <td><?php echo $data->getElementValue('shop_transport_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_transport_id', 'number'); ?></td>
    <td><?php echo $data->getElementValue('shop_transport_driver_id'); ?></td>
    <td><?php echo $data->values['text']; ?></td>
    <td>
        <?php echo $data->getElementValue('create_user_id'); ?>
        <br><?php echo $data->getElementValue('update_user_id'); ?>
    </td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/edit', array('id' => 'id'), array('is_show' => true, 'is_show_admin' => true), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
        </ul>
    </td>
</tr>
