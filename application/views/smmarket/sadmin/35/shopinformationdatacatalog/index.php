<tr id="record_<?php echo $data->id;?>">
    <td>
        <label>
            <input name="set_is_public" href="<?php echo $siteData->urlBasic . '/cabinet/shopinformationdatacatalog/save?id=' . $data->id; ?>&type=<?php echo Arr::path($siteData->urlParams, 'type', '0');?>&shop_id=<?php echo $siteData->shopID;?>"
                   type="checkbox" class="flat-red"<?php if ($data->values['is_public'] == 1) {
                echo ' checked';
            } ?>>
        </label>
    </td>
    <td><?php echo $data->values['name']; ?></td>
    <td style="padding-top: 3px;">
        <a buttom_list="edit" data-id="<?php echo $data->id;?>" href="<?php echo $siteData->urlBasic.'/cabinet/shopinformationdatacatalog/edit?id='.$data->id;?>&shop_id=<?php echo $siteData->shopID;?>" class="btn btn-default btn-sm checkbox-toggle" style="margin-top: 5px;">изменить</a>
        <a buttom_list="edit" data-id="<?php echo $data->id;?>" href="<?php echo $siteData->urlBasic.'/cabinet/shopinformationdatacatalog/clone?id='.$data->id;?>" class="btn btn-default btn-sm checkbox-toggle" style="margin-top: 5px;">дублировать</a>
        <a buttom_list="del" data-id="<?php echo $data->id;?>"  href="<?php echo $siteData->urlBasic.'/cabinet/shopinformationdatacatalog/del?id='.$data->id;?>&shop_id=<?php echo $siteData->shopID;?>" class="btn btn-danger btn-sm checkbox-toggle" style="margin-top: 5px;">удалить</a>
    </td>
</tr>