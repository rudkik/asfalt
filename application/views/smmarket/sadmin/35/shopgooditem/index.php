<tr>
    <td>
        <input name="good_item_names[]" type="text" class="form-control" value="<?php echo $data->values['name']; ?>"/>
    </td>
    <td>
        <input name="good_item_storage_counts[]" type="text" class="form-control" value="<?php echo $data->values['storage_count']; ?>" autocomplete="off"/>
    </td>
    <td>
        <input name="good_item_ids[]" hidden="hidden" value="<?php echo $data->id; ?>"/>
        <ul class="list-inline tr-button delete">
            <li class="tr-remove"><a delete="tr" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>