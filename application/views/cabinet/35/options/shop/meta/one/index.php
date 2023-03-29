<tr>
    <td><input class="form-control" name="metas[<?php echo $data->values['id']; ?>][name]" value="<?php echo $data->values['name']; ?>" placeholder="Название (name)"></td>
    <td><input class="form-control" name="metas[<?php echo $data->values['id']; ?>][content]" value="<?php echo $data->values['content']; ?>" placeholder="Контент (content)"></td>
    <td><input class="form-control" name="metas[<?php echo $data->values['id']; ?>][itemprop]" value="<?php echo $data->values['itemprop']; ?>" placeholder="Атрибут (temprop)"></td>
    <td><input class="form-control" name="metas[<?php echo $data->values['id']; ?>][property]" value="<?php echo $data->values['property']; ?>" placeholder="Атрибут (property)"></td>
    <td><input class="form-control" name="metas[<?php echo $data->values['id']; ?>][addition]" value="<?php echo $data->values['addition']; ?>" placeholder="Дополнительные атрибуты"></td>
    <td><input class="form-control" name="metas[<?php echo $data->values['id']; ?>][url]" value="<?php echo $data->values['url']; ?>" placeholder="Ссылка (URL)"></td>
    <td>
        <ul class="list-inline tr-button delete">
            <li><a href="" class="link-red text-sm" data-action="tr-delete"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>