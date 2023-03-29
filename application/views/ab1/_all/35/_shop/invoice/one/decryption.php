<tr>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date']); ?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td><?php echo $data->getElementValue('shop_client_attorney_id', 'number'); ?></td>
    <td><?php echo $data->getElementValue('shop_client_contract_id', 'number', 'без договора'); ?></td>
    <td><?php echo $data->getElementValue('product_type_id'); ?></td>
    <td><?php if($data->values['shop_client_attorney_id'] > 0){echo 'безналичный';}else{echo 'наличный';} ?></td>
    <td><?php if($data->values['is_delivery'] == 1){echo 'с доставкой';}else{echo 'без доставки';} ?></td>
    <td><?php echo $data->getElementValue('check_type_id', 'name', 'Не проверено'); ?></td>
    <td>
        <span <?php $list = Arr::path($data->values['options'], 'date_give_to_clients', array()); if(count($list) > 0){ ?> data-action="tooltip" data-original-title="<?php
        $s = '';
        foreach ($list as $one){
            $s .= Helpers_DateTime::getDateTimeFormatRus($one) . '<br>';
        }
        echo $s;
        ?>" data-html="true"
        <?php } ?>><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date_give_to_client']); ?></span>
    </td>
    <td>
        <span <?php $list = Arr::path($data->values['options'], 'date_received_from_clients', array()); if(count($list) > 0){ ?> data-action="tooltip" data-original-title="<?php
        $s = '';
        foreach ($list as $one){
            $s .= Helpers_DateTime::getDateTimeFormatRus($one) . '<br>';
        }
        echo $s;
        ?>" data-html="true"
        <?php } ?>><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date_received_from_client']); ?></span>
    </td>
    <td>
        <span <?php $list = Arr::path($data->values['options'], 'date_give_to_bookkeepings', array()); if(count($list) > 0){ ?> data-action="tooltip" data-original-title="<?php
        $s = '';
        foreach ($list as $one){
            $s .= Helpers_DateTime::getDateTimeFormatRus($one) . '<br>';
        }
        echo $s;
        ?>" data-html="true"
        <?php } ?>><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date_give_to_bookkeeping']); ?></span>
    </td>

    <td>
        <ul class="list-inline tr-button delete">
            <?php if($data->values['check_type_id'] == Model_Ab1_CheckType::CHECK_TYPE_NOT_CHECK || $siteData->operation->getIsAdmin()){?>
                <?php if((!Request_RequestParams::getParamBoolean('is_send_esf')) || $siteData->operation->getIsAdmin()){ ?>
                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/edit', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
                <?php } ?>
            <?php }else{ ?>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/edit', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
            <?php } ?>
        </ul>
    </td>
</tr>
