<tr>
    <td><input name="name" type="text" class="form-control" value="<?php echo $data->values['name'];?>"></td>
    <td><input name="info" type="text" class="form-control" value="<?php echo $data->values['text'];?>"></td>
    <td style="width: 178px;">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" type="text" hidden="hidden" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
    	<a data-id="<?php echo $data->id;?>" buttom-tr="save" href="<?php echo $siteData->urlBasic; ?>/cabinet/shoppaidtype/save" class="btn btn-default btn-sm checkbox-toggle" style="margin-top: 5px;">сохранить</a>
    	<a data-id="<?php echo $data->id;?>" buttom-tr="del" href="<?php echo $siteData->urlBasic; ?>/cabinet/shoppaidtype/del" class="btn btn-danger btn-sm checkbox-toggle" style="margin-top: 5px;">удалить</a>
    </td>
</tr>