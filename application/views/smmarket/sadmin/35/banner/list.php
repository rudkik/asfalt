<tr id="record_<?php echo $data->id;?>">
    <td>
        <label>
            <input name="set_is_public" href="<?php echo $siteData->urlBasic . '/cabinet/banner/save?id=' . $data->id; ?>&type=<?php echo Arr::path($siteData->urlParams, 'type', '0');?>&shop_id=<?php echo $siteData->shopID;?>"
                    type="checkbox" class="flat-red"<?php if ($data->values['is_public'] == 1) {
                echo ' checked';
            } ?>>
        </label>
    </td>
    <td style="text-align: center"><img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 70, 65); ?>"
                                        style="width: 70px; height: 65px;"></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['text']; ?></td>
    <td><?php echo $data->values['created_at']; ?></td>
    <td style="padding-top: 3px;">
        <a buttom_list="edit" data-id="<?php echo $data->id;?>" href="<?php echo $siteData->urlBasic.'/cabinet/banner/edit?id='.$data->id;?>" class="btn btn-default btn-sm checkbox-toggle" style="margin-top: 5px;">изменить</a>
        <a buttom_list="edit" data-id="<?php echo $data->id;?>" href="<?php echo $siteData->urlBasic.'/cabinet/banner/clone?id='.$data->id;?>" class="btn btn-default btn-sm checkbox-toggle" style="margin-top: 5px;">дублировать</a>
        <a buttom_list="del" data-id="<?php echo $data->id;?>"  href="<?php echo $siteData->urlBasic.'/cabinet/banner/del?id='.$data->id;?>" class="btn btn-default btn-sm checkbox-toggle" style="margin-top: 5px;">удалить</a>
    </td>
</tr>