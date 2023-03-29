<tr>
    <td data-number="<?php echo $data->values['name']; ?>"><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['driver']; ?></td>
    <?php if($data->values['tare_type_id'] == Model_Ab1_TareType::TARE_TYPE_CLIENT){ ?>
        <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <?php }else{ ?>
        <td><?php echo $data->getElementValue('shop_transport_company_id'); ?></td>
        <td><?php echo $data->getElementValue('shop_transport_id'); ?></td>
    <?php } ?>
    <td class="text-right" id="weight-<?php echo $data->id; ?>" <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo Func::getNumberStr($data->values['weight'], TRUE, 3, false); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['updated_at']); ?></td>
    <td><button onclick="sendTarra(<?php echo $data->id; ?>);" class="btn bg-navy btn-flat">Взвесить</button></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopcartare/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopcartare/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopcartare/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <?php } ?>
        </ul>
    </td>
</tr>
