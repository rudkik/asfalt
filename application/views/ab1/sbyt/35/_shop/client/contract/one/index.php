<?php $isShow = $siteData->shopMainID != $siteData->shopID || (true && !$siteData->operation->getIsAdmin());?>
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
    <td <?php if($data->values['shop_client_id'] < 1){ ?>class="tr-red"<?php } ?>>
        <?php echo $data->getElementValue('shop_client_id'); ?>
    </td>
    <td <?php if(empty($data->values['number'])){ ?>class="tr-red"<?php } ?>><?php echo $data->values['number']; ?></td>
    <td <?php if(empty($data->values['from_at'])){ ?>class="tr-red"<?php } ?>><?php echo Helpers_DateTime::getDateFormatRus($data->values['from_at']); ?></td>
    <td <?php if(empty($data->values['to_at']) && $data->values['is_perpetual'] == 0){ ?>class="tr-red"<?php } ?>>
        <?php if($data->values['is_perpetual'] == 1){ ?>
            До исполнения обязательства
        <?php }else{ ?>
            <?php echo Helpers_DateTime::getDateFormatRus($data->values['to_at']); ?>
        <?php } ?>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td class="text-right">
        <a data-id="block_amount" href="<?php echo Func::getFullURL($siteData, '/shopcaritem/contract', array(), array('shop_client_contract_id' => $data->id), $data->values); ?>"><?php echo Func::getNumberStr($data->values['block_amount'], TRUE, 2, FALSE); ?></a>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['balance'], TRUE, 2, FALSE); ?></td>
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
        <?php echo $data->getElementValue('create_user_id'); ?>
        <br><?php echo $data->getElementValue('update_operation_id'); ?>
    </td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <?php if($isShow){ ?>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/edit', array('id' => 'id'), array('is_show' => 1), $data->values, false, false, true); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
            <?php }else{ ?>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/edit', array('id' => 'id'), array(), $data->values, false, false, true); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
                <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/del', array('id' => 'id'), array(), $data->values, false, false, true); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/del', array('id' => 'id'), array('is_undel' => 1), $data->values, false, false, true); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <?php } ?>
        </ul>
    </td>
</tr>
