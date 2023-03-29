<tr>
    <td>
        <input data-action="boolean" name="params[<?php echo $data->values['name'];?>][is_public]" <?php if (Arr::path($data->values, 'is_public', '') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
    </td>
    <td><?php echo $data->values['title']['ru'];?></td>
    <td>
        <?php if($data->values['type'] == 'boolean'){?>
            <?php $value = intval(Arr::path($data->values, 'value', -1));?>
            <select class="form-control select2" name="params[<?php echo $data->values['name'];?>][value]" style="width: 100%">
                <option value="" data-id="" <?php if(($value !== 0) && ($value !== 1)){echo 'selected';} ?>>Значение не выбрано</option>
                <option value="0" data-id="0" <?php if($value === 0){echo 'selected';} ?>>Нет</option>
                <option value="1" data-id="1" <?php if($value === 1){echo 'selected';} ?>>Да</option>
            </select>
        <?php }elseif($data->values['type'] == 'date'){?>
            <input class="form-control" placeholder="Значение" name="params[<?php echo $data->values['name'];?>][value]" type="datetime" value="<?php echo Arr::path($data->values, 'value', '');?>">
        <?php }else{?>
            <input class="form-control" placeholder="Значение" name="params[<?php echo $data->values['name'];?>][value]" type="text" value="<?php echo Arr::path($data->values, 'value', '');?>">
        <?php }?>
    </td>
    <td>
        <input class="form-control" placeholder="Название переменной" name="params[<?php echo $data->values['name'];?>][field]" type="text" value="<?php echo Arr::path($data->values, 'field', '');?>">
    </td>
</tr>