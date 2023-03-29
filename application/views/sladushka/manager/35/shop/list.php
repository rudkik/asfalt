<tr id="record_<?php echo $data->id;?>">
    <td>
        <label>
            <input name="set_is_public" href="<?php echo $siteData->urlBasic . '/manager/shop/save?id=' . $data->id; ?>&type=<?php echo Arr::path($siteData->urlParams, 'type', '0');?>&shop_id=<?php echo $siteData->shopID;?>"
                   type="checkbox" class="flat-red"<?php if ($data->values['is_public'] == 1) {
                echo ' checked';
            } ?>>
        </label>
    </td>
    <td style="text-align: center"><img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 70, 70); ?>"
                                        style="width: 70px; height: 65px;"></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['domain']; ?></td>
    <td><?php echo $data->values['sub_domain']; ?></td>
    <td><?php echo $data->values['to_pay_at']; ?></td>
    <td>
        <a style="margin-top: 1px; margin-bottom: 1px;" data-id="<?php echo $data->id;?>" href="<?php echo $siteData->urlBasic.'/manager/shop/index';?>" class="btn btn-default btn-sm checkbox-toggle">Выбрать</a>
        <a buttom_list="edit" style="margin-top: 1px; margin-bottom: 1px;" data-id="<?php echo $data->id;?>" href="<?php echo $siteData->urlBasic.'/manager/shop/edit?id='.$data->id;?>" class="btn btn-default btn-sm checkbox-toggle">изменить</a>
        <a buttom_list="edit" style="margin-top: 1px; margin-bottom: 1px;" data-id="<?php echo $data->id;?>" href="<?php echo $siteData->urlBasic.'/manager/site/index?id='.$data->id;?>" class="btn btn-default btn-sm checkbox-toggle">создать сайт</a>
        <a buttom_list="del" style="margin-top: 1px; margin-bottom: 1px;" data-id="<?php echo $data->id;?>"  href="<?php echo $siteData->urlBasic.'/manager/shop/del?id='.$data->id;?>" class="btn btn-default btn-sm checkbox-toggle">удалить</a>

    </td>
</tr>
