<tr>
    <td><?php echo  $data->values['bill_number'] ?>></td>
    <td><?php echo $data->values['updated_at']; ?></td>
    <td><?php echo $data->values['bill_finish_count']; ?></td>
    <td><?php echo $data->values['bill_finish_amount']; ?></td>
    <td style="padding-top: 3px;">
        <a buttom_list="edit" data-id="<?php echo $data->id;?>" href="<?php echo $siteData->urlBasic.'/cabinet/shopreport/day-edit?id='.$data->id;?>" class="btn btn-default btn-sm checkbox-toggle" style="margin-top: 5px;">изменить</a>
        <a buttom_list="del" data-id="<?php echo $data->id;?>"  href="<?php echo $siteData->urlBasic.'/cabinet/shopreport/day-del?id='.$data->id;?>" class="btn btn-default btn-sm checkbox-toggle" style="margin-top: 5px;">удалить</a>
    </td>
</tr>