<tr id="record_<?php echo $data->id;?>">
    <td>
        <label>
            <input name="set_is_public" href="<?php echo $siteData->urlBasic . '/cabinet/shopemail/save?id=' . $data->id; ?>&type=<?php echo Arr::path($siteData->urlParams, 'type', '0');?>&shop_id=<?php echo $siteData->shopID;?>"
                   type="checkbox" class="flat-red"<?php if ($data->values['is_public'] == 1) {
                echo ' checked';
            } ?>>
        </label>
    </td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.email_type.name', ''); ?></td>
    <td style="padding-top: 3px;">
        <a buttom_list="edit" style="margin-top: 1px; margin-bottom: 1px;" data-id="<?php echo $data->id;?>" href="<?php echo $siteData->urlBasic.'/cabinet/shopemail/edit?id='.$data->id;?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="btn btn-default btn-sm checkbox-toggle" style="margin-top: 5px;">изменить</a>
        <a buttom_list="edit" data-id="<?php echo $data->id;?>" href="<?php echo $siteData->urlBasic.'/cabinet/shopemail/clone?id='.$data->id;?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="btn btn-default btn-sm checkbox-toggle" style="margin-top: 5px;">дублировать</a>
        <a buttom_list="del" style="margin-top: 1px; margin-bottom: 1px;" data-id="<?php echo $data->id;?>"  href="<?php echo $siteData->urlBasic.'/cabinet/shopemail/del?id='.$data->id;?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="btn btn-danger btn-sm checkbox-toggle" style="margin-top: 5px;">удалить</a>
    </td>
</tr>
