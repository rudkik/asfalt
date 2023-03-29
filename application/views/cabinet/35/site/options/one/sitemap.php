<tr>
    <td><input name="url_prefix[]" type="text" class="form-control" rows="5" placeholder="Префикс ссылки" value="<?php echo $data->values['url_prefix'];?>"></td>
    <td>
        <select class="form-control select2" style="width: 100%;" name="function[]">
            <option></option>
            <?php echo $data->additionDatas['view::site/combobox-views']; ?>
        </select>
    </td>
    <td><input name="url_postfix[]" type="text" class="form-control" rows="5" placeholder="Постфикс ссылки" value="<?php echo $data->values['url_postfix'];?>"></td>
    <td><input name="url_param[]" type="text" class="form-control" rows="5" placeholder="Параметры запроса" value="<?php echo $data->values['url_param'];?>"></td>
    <td><input name="priority[]" type="text" class="form-control" rows="5" placeholder="Приоритет" value="<?php echo $data->values['priority'];?>"></td>
    <td style="width: 98px;">
        <a data-id="0" buttom-tr="del" href="" class="btn btn-danger btn-sm checkbox-toggle">Удалить</a>
    </td>
</tr>