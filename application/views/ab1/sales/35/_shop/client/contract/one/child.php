<?php $isShow = $siteData->shopMainID != $siteData->shopID; ?>
<tr data-basic="<?php echo $data->values['basic_shop_client_contract_id']; ?>">
    <td></td>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <td>
        <?php echo $data->getElementValue('shop_client_id'); ?>
    </td>
    <td>
        <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/edit', array('id' => 'id'), array(), $data->values, false, false, true); ?>" class="link-blue"><?php echo $data->values['number']; ?></a>
    </td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['from_at']); ?></td>
    <td>
        <?php if($data->values['is_perpetual'] == 1){ ?>
            До исполнения обязательства
        <?php }else{ ?>
            <?php echo Helpers_DateTime::getDateFormatRus($data->values['to_at']); ?>
        <?php } ?>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td>
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
