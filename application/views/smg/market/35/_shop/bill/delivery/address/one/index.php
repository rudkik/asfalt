<tr>
    <td><?php echo $data->getElementValue('shop_source_id'); ?></td>
    <td><?php echo $data->values['city_name']; ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['street']; ?></td>
    <td><?php echo $data->values['house']; ?></td>
    <td><?php echo $data->values['apartment']; ?></td>
    <td><?php echo $data->values['latitude']; ?></td>
    <td><?php echo $data->values['longitude']; ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopbilldeliveryaddress/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopbilldeliveryaddress/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopbilldeliveryaddress/del', array('id' => 'id'), array('is_undel' => 1), $data->values);  ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
