<tr>
    <td><input class="form-control" name="redirects[<?php echo $data->values['id']; ?>][old]" value="<?php echo $data->values['old']; ?>"></td>
    <td><input class="form-control" name="redirects[<?php echo $data->values['id']; ?>][new]" value="<?php echo $data->values['new']; ?>"></td>
    <td>
        <ul class="list-inline tr-button delete">
            <li><a href="" class="link-red text-sm" data-action="tr-delete"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>