<?php $contracts = Arr::path($data->additionDatas, 'contracts', array());?>
<tr <?php if(count($contracts) != 1){?>style="background: rgba(221, 75, 57, 0.5)"<?php }?>>
    <td><?php echo $data->values['old_id']; ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td class="text-right"><?php $tmp = 1; if ($data->values['is_receive'] == 0){ $tmp = -1; } ?><?php echo Func::getNumberStr($data->values['amount'] * $tmp, TRUE, 2, FALSE); ?></td>
    <td>
        <?php if ($data->values['is_cache'] == 1){ ?>
            Наличные
        <?php }else{ ?>
            Безналичные
        <?php } ?>
    </td>
    <td>
        <?php if ($data->values['is_receive'] == 1){ ?>
            Приход
        <?php }else{ ?>
            Расход
        <?php } ?>
    </td>
    <td>
        <select name="shop_client_contract_ids[<?php echo $data->values['id']; ?>]" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0" <?php if(count($contracts) < 1){?>selected<?php }?>>Без значения</option>
            <?php foreach ($contracts as $id => $contract){
                ?>
                <option value="<?php echo $id; ?>" data-id="<?php echo $id; ?>" <?php if(count($contracts) == 1){?>selected<?php }?>>№<?php echo $contract->values['number']; ?> от <?php echo Helpers_DateTime::getDateFormatRus($contract->values['from_at']); ?> - <?php if($contract->values['executor_shop_worker_id'] > 0){ echo $contract->getElementValue('executor_shop_worker_id'); }elseif($contract->values['client_contract_type_id'] == Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_SALE_PRODUCT){ echo 'СБЫТ'; } ?></option>
            <?php } ?>
        </select>
    </td>
    <td>
        <?php foreach ($contracts as $id => $contract){?>
            <?php $files = Arr::path(json_decode($contract->values['options'], true), 'files', array());?>
            <?php
            foreach ($files as $file){
                if(empty($file)){
                    continue;
                }
                ?>
                <a target="_blank" href="<?php echo Arr::path($file, 'file', ''); ?>">№<?php echo $contract->values['number']; ?> от <?php echo Helpers_DateTime::getDateFormatRus($contract->values['from_at']); ?></a><br>
            <?php } ?>
        <?php } ?>
    </td>
</tr>
