<tr>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date']); ?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_delivery_department_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td><?php echo $data->getElementValue('shop_client_attorney_id', 'number', 'без доверенности'); ?></td>
    <td><?php echo $data->getElementValue('shop_client_contract_id', 'number', 'без договора'); ?></td>
    <td><?php echo $data->getElementValue('act_service_paid_type_id'); ?></td>
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
    <?php if(!Request_RequestParams::getParamBoolean('is_send_esf')){?>
        <td class="text-right"><?php echo Helpers_DateTime::diffTimeRUS(Helpers_DateTime::plusDays($data->values['date'], 10), date('Y-m-d H:i:d')); ?></td>
    <?php }?>
    <?php if((!Request_RequestParams::getParamBoolean('is_send_esf')) || $siteData->operation->getIsAdmin()){ ?>
        <td>
            <ul class="list-inline tr-button delete">
                <?php if($data->values['check_type_id'] == Model_Ab1_CheckType::CHECK_TYPE_NOT_CHECK || $siteData->operation->getIsAdmin()){?>
                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopactservice/edit', array(), array('id' => $data->values['id']), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
                <?php }else{ ?>
                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopactservice/edit', array(), array('id' => $data->values['id']), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
                <?php } ?>
            </ul>
        </td>
    <?php } ?>
</tr>
