<tr>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['weighted_at']); ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->getElementValue('shop_storage_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_product_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td><?php echo $data->getElementValue('shop_turn_place_id'); ?></td>
    <td><?php echo $data->getElementValue('asu_operation_id'); ?></td>
    <?php if($siteData->operation->getIsAdmin()){ ?>
        <td style="font-size: 14px;" class="text-right">
            <?php if($data->values['shop_transport_waybill_id'] > 0){?>
                <a target="_blank" href="<?php echo $siteData->urlBasic . '/atc/shoptransportwaybill/edit?id=' . $data->values['shop_transport_waybill_id']; ?>"><?php echo $data->getElementValue('shop_transport_waybill_id', 'number'); ?></a>
            <?php } ?>
        </td>
    <?php } ?>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopproductstorage/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopproductstorage/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopproductstorage/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
