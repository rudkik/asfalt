<?php
$files = Arr::path($data->values['options'], 'files', array());
$isEmptyFile = true;
foreach ($files as $file){
    if(!empty($file)){
        $isEmptyFile = false;
    }
}
?>
<tr <?php if($data->values['is_basic'] == 0){ ?>class="additoin-agreement"<?php } ?>>
    <td>
        <?php if($data->values['is_basic'] == 1 && $data->values['additional_agreement_count'] > 0){ ?>
            <i class="fa fa-fw fa-plus" style="cursor: pointer;" data-action="show-tr-contract" data-id="<?php echo $data->values['id']; ?>" data-url="/<?php echo $siteData->actionURLName; ?>/shopclientcontract/child"></i>
        <?php } ?>
    </td>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <?php if($data->values['is_basic'] == 1){ ?>
        <td <?php if(empty($data->values['number'])){ ?>class="tr-red"<?php } ?>><?php echo $data->values['number']; ?></td>
        <td></td>
    <?php }else{ ?>
        <td>
            <?php if($data->values['is_add_basic_contract'] == 1){ ?><span class="text-red">сумма включена в договор</span><?php } ?>
        </td>
        <td class="text-right <?php if(empty($data->values['number'])){ ?>tr-red<?php } ?>"><?php echo $data->values['number']; ?></td>
    <?php } ?>
    <td <?php if(empty(Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']))){ ?>class="tr-red"<?php } ?> ><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td <?php if(empty($data->getElementValue('shop_client_id'))){ ?>class="tr-red"<?php } ?> >
        <?php echo $data->getElementValue('shop_client_id'); ?>
        <br><?php echo $data->getElementValue('shop_client_id', 'bin'); ?>
    </td>
    <td class="text-right"><?php echo str_replace('{amount}', Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE), $data->getElementValue('currency_id', 'symbol', '{amount}') ); ?></td>
    <td <?php if(empty(Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['from_at']))){ ?>class="tr-red"<?php } ?> ><?php echo Helpers_DateTime::getDateFormatRus($data->values['from_at']); ?></td>
    <td <?php if(empty(Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['to_at'])) && $data->values['is_perpetual'] != 1){ ?>class="tr-red"<?php } ?> >
        <?php if($data->values['is_perpetual'] == 1){ ?>
            До исполнения обязательства
        <?php }else{ ?>
            <?php echo Helpers_DateTime::getDateFormatRus($data->values['to_at']); ?>
        <?php } ?>
    </td>
    <td <?php if(empty($data->getElementValue('client_contract_type_id'))){ ?>class="tr-red"<?php } ?> ><?php echo $data->getElementValue('client_contract_type_id'); ?></td>
    <td <?php if(empty($data->getElementValue('client_contract_status_id'))){ ?>class="tr-red"<?php } ?> ><?php echo $data->getElementValue('client_contract_status_id'); ?></td>
    <td <?php if(empty($data->getElementValue('executor_shop_worker_id'))){ ?>class="tr-red"<?php } ?> ><?php echo $data->getElementValue('executor_shop_worker_id'); ?></td>
    <td>
        <?php if($data->values['is_redaction_client'] == 1){ ?>
            Контрагент
        <?php }else{ ?>
            АБ1
        <?php } ?>
    </td>
    <td <?php if($isEmptyFile){ ?>class="tr-red"<?php } ?>>
        <?php
        foreach ($files as $file){
            if(empty($file)){
                continue;
            }
        ?>
            <a target="_blank" href="<?php echo Helpers_URL::getFileBasicURL($data->values['shop_id'], $siteData)  . Arr::path($file, 'file', ''); ?>">Скачать</a><br>
        <?php } ?>
    </td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <?php
            $fixed = array();
            $button = 'Изменить';
            $isDelete = true;
            if($data->values['client_contract_type_id'] > 0 && $data->values['client_contract_type_id'] <= 100 && !$siteData->operation->getIsAdmin()){
                $fixed['is_show'] = 1;
                $button = 'Просмотр';
                $isDelete = false;
            }
            ?>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/edit', array('id' => 'id'), $fixed, $data->values, false, false, true); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> <?php echo $button; ?></a></li>
            <?php if($isDelete){ ?>
                <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/del', array('id' => 'id'), array(), $data->values, false, false, true); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/del', array('id' => 'id'), array('is_undel' => 1), $data->values, false, false, true); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <?php } ?>
        </ul>
    </td>
</tr>
