<tr id="record_<?= $data->id;?>">
    <td style="text-align: left; position: relative; padding: 8px;"><?= $data->values['title']; ?></td>
    <td><?= $data->values['data']; ?></td>
    <td style="padding-top: 3px;">
        <a buttom_list="edit" data-id="<?= $data->id;?>" href="<?= $siteData->urlBasic.'/cabinet/shopcounter/edit?id=' .$data->id;?>"
           class="btn btn-default btn-sm checkbox-toggle" style="margin-top: 5px;">изменить</a>
        <a buttom_list="edit" data-id="<?php echo $data->id;?>" href="<?php echo $siteData->urlBasic.'/cabinet/shopcounter/clone?id='.$data->id;?>" class="btn btn-default btn-sm checkbox-toggle" style="margin-top: 5px;">дублировать</a>
        <a buttom_list="del" data-id="<?= $data->id;?>"  href="<?= $siteData->urlBasic.'/cabinet/shopcounter/delete?id='.$data->id;?>"
           class="btn btn-default btn-sm checkbox-toggle" style="margin-top: 5px;">удалить</a>
    </td>
</tr>
