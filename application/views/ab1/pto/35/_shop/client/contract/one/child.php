<?php
$files = Arr::path($data->values['options'], 'files', array());
$isEmptyFile = true;
foreach ($files as $file){
    if(!empty($file)){
        $isEmptyFile = false;
    }
}
?>
<tr data-basic="<?php echo $data->values['basic_shop_client_contract_id']; ?>">
    <td class="addition-agreement"></td>
    <td></td>
    <td class="text-right"><?php echo $data->values['number']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td>
        <?php echo $data->getElementValue('shop_client_id'); ?>
        <br><?php echo $data->getElementValue('shop_client_id', 'bin'); ?>
    </td>
    <td class="text-right"><?php echo str_replace('{amount}', Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE), $data->getElementValue('currency_id', 'symbol', '{amount}') ); ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['from_at']); ?></td>
    <td>
        <?php if($data->values['is_perpetual'] == 1){ ?>
            До исполнения обязательства
        <?php }else{ ?>
            <?php echo Helpers_DateTime::getDateFormatRus($data->values['to_at']); ?>
        <?php } ?>
    </td>
    <td><?php echo $data->getElementValue('client_contract_type_id'); ?></td>
    <td><?php echo $data->values['subject']; ?></td>
    <td><?php echo $data->getElementValue('client_contract_status_id'); ?></td>
    <td><?php echo $data->getElementValue('executor_shop_worker_id'); ?></td>
    <td>
        <?php if($data->values['is_redaction_client'] == 1){ ?>
            Контрагент
        <?php }else{ ?>
            АБ1
        <?php } ?>
    </td>
    <td <?php if($isEmptyFile){ ?>class="tr-red"<?php } ?>>
        <?php
        $files = Arr::path($data->values['options'], 'files', array());
        foreach ($files as $file){
            if(empty($file)){
                continue;
            }
            ?>
            <a target="_blank" href="<?php echo Helpers_URL::getFileBasicURL($data->values['shop_id'], $siteData) . Arr::path($file, 'file', ''); ?>">Скачать</a><br>
        <?php } ?>
    </td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <?php
            $fixed = array();
            $button = 'Изменить';
            $isDelete = true;
            if($data->values['client_contract_type_id'] != Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_MATERIAL
                && $data->values['client_contract_type_id'] != Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_MATERIAL
                && $data->values['client_contract_type_id'] != Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_PRODUCT_SHOP
                && !$siteData->operation->getIsAdmin()){
                $fixed['is_show'] = 1;
                $button = 'Просмотр';
                $isDelete = false;
            }
            if($data->values['is_fixed_contract'] == 1 && !$siteData->operation->getIsAdmin()){
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
