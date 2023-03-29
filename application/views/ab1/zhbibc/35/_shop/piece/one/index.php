<tr>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo str_replace("\r\n", '<br>', $data->values['text']); ?></td>
    <td><?php echo $data->getElementValue('shop_driver_id'); ?></td>
    <td>
        <?php
        if($data->values['is_one_attorney'] == 1){
            echo $data->getElementValue('shop_client_attorney_id', 'number');
        }else {
            echo 'множество доверенностей';
        }
        ?>
    </td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_delivery_id.name', 'Без доставки'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <?php if($siteData->operation->getIsAdmin()){ ?>
        <td style="font-size: 14px;" class="text-right">
            <?php if($data->values['shop_transport_waybill_id'] > 0){?>
                <a target="_blank" href="<?php echo $siteData->urlBasic . '/atc/shoptransportwaybill/edit?id=' . $data->values['shop_transport_waybill_id']; ?>"><?php echo $data->getElementValue('shop_transport_waybill_id', 'number'); ?></a>
            <?php } ?>
        </td>
    <?php } ?>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <?php if((strtotime(strftime('%Y-%m-%d', strtotime($data->values['created_at']))) + 60*60*24 >= time()) || (($siteData->operation->getIsAdmin()))){ ?>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shoppiece/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
                <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoppiece/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoppiece/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <?php }else{ ?>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shoppiece/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
            <?php } ?>
        </ul>
    </td>
</tr>
