<tr id="record_<?php echo $data->id;?>">
    <td>
        <label>
            <input name="set_is_public" href="<?php echo $siteData->urlBasic . '/cabinet/shopaddress/save?id=' . $data->id; ?>&type=<?php echo Arr::path($siteData->urlParams, 'type', '0');?>&shop_id=<?php echo $siteData->shopID;?>"
                   type="checkbox" class="flat-red"<?php if ($data->values['is_public'] == 1) {
                echo ' checked';
            } ?>>
        </label>
    </td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo Helpers_Address::getAddressStr($siteData, $data->values); ?></td>
    <td style="padding-top: 3px;">
        <a buttom_list="edit" data-id="<?php echo $data->id;?>" href="<?php echo $siteData->urlBasic.'/cabinet/shopaddress/edit?id='.$data->id;?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="btn btn-default btn-sm checkbox-toggle" style="margin-top: 5px;">изменить</a>
        <a buttom_list="edit" data-id="<?php echo $data->id;?>" href="<?php echo $siteData->urlBasic.'/cabinet/shopaddress/clone?id='.$data->id;?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="btn btn-default btn-sm checkbox-toggle" style="margin-top: 5px;">дублировать</a>
        <a buttom_list="del" data-id="<?php echo $data->id;?>"  href="<?php echo $siteData->urlBasic.'/cabinet/shopaddress/del?id='.$data->id;?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="btn btn-danger btn-sm checkbox-toggle" style="margin-top: 5px;">удалить</a>
    </td>
</tr>