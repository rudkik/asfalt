<tr>
    <td>
        <?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name' ,'');  ?>
        <input name="shop_table_filters[_<?php echo $data->id; ?>][rubric]" value="<?php echo $data->values['shop_table_rubric_id']; ?>" hidden>
    </td>
    <td>
        <input list="shop_table_filters-<?php echo $data->values['shop_table_rubric_id']; ?>" name="shop_table_filters[_<?php echo $data->id; ?>][name]" type="text" class="form-control" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
    </td>
    <td>
        <ul class="list-inline tr-button delete">
            <li class="tr-remove"><a delete="tr" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>