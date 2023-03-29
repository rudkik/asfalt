<tr>
    <td>
        <select name="shop_table_rubric_ids[]" class="form-control select2" style="width: 100%;">
            <option value="-1" data-id="-1"></option>
            <?php echo str_replace('data-id="'.$data->id.'"', 'data-id="'.$data->id.'" selected', $siteData->replaceDatas['view::_shop/_table/rubric/list/list']); ?>
        </select>
    </td>
    <td>
        <ul class="list-inline tr-button delete">
            <li class="tr-remove"><a delete="tr" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>