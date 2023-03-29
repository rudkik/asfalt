<table class="table table-hover table-db table-tr-line" style="max-width: 500px;">
    <tbody>
    <tr>
        <th class="tr-header-public">
            <span>
                <input data-action="set-boolean" type="checkbox" class="minimal">
            </span>
        </th>
        <th class="tr-header-rubric">Название</th>
        <th class="tr-header-rubric">Приоритет</th>
    </tr>
    <tr>
        <td>
            <input data-action="boolean" name="<?php echo Request_RequestParams::READ_REQUEST_TYPE_NAME;?>[params][is_read]" <?php if (Arr::path($data->values, 'params.is_read', 1) == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
        </td>
        <td>Данные с заданных параметров</td>
        <td>
            <input class="form-control" placeholder="Приоритет" name="<?php echo Request_RequestParams::READ_REQUEST_TYPE_NAME;?>[params][priority]" type="text" value="<?php echo Arr::path($data->values, 'params.priority', '');?>">
        </td>
    </tr>
    <tr>
        <td>
            <input data-action="boolean" name="<?php echo Request_RequestParams::READ_REQUEST_TYPE_NAME;?>[get][is_read]" <?php if (Arr::path($data->values, 'get.is_read', 1) == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
        </td>
        <td>Данные с $_GET</td>
        <td>
            <input class="form-control" placeholder="Приоритет" name="<?php echo Request_RequestParams::READ_REQUEST_TYPE_NAME;?>[get][priority]" type="text" value="<?php echo Arr::path($data->values, 'get.priority', '');?>">
        </td>
    </tr>
    <tr>
        <td>
            <input data-action="boolean" name="<?php echo Request_RequestParams::READ_REQUEST_TYPE_NAME;?>[post][is_read]" <?php if (Arr::path($data->values, 'post.is_read', 1) == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
        </td>
        <td>Данные с $_POST</td>
        <td>
            <input class="form-control" placeholder="Приоритет" name="<?php echo Request_RequestParams::READ_REQUEST_TYPE_NAME;?>[post][priority]" type="text" value="<?php echo Arr::path($data->values, 'post.priority', '');?>">
        </td>
    </tr>
    </tbody>
</table>