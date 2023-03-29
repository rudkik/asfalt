<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shoppricelist/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['from_at']); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['to_at']); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shoppricelist/edit', array('id' => 'id'), array('is_show' => true), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shoppricelist/calc_balance', array('id' => 'id'), array(), $data->values); ?>" class="link-black"><i class="fa fa-calculator margin-r-5"></i> Пересчитать баланс</a></li>
        </ul>
    </td>
</tr>
