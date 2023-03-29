<?php
if(key_exists('integrations', $data->values)) {
    $tmp = $data->values['integrations'];
}else{
    $tmp = array();
}
foreach ($tmp as $index => $value){
    ?>
    <tr>
        <td>
            <select data-type="select2" name="integrations[<?php echo $index;?>][field]" class="form-control select2" style="width: 100%;">
                <option value=""></option>
                <?php
                $s = 'data-id="'.Arr::path($value, 'field', '').'"';
                echo trim(str_replace($s, $s.' selected', $fields));
                ?>
            </select>
        </td>
        <td>
            <input name="integrations[<?php echo $index;?>][is_template]" <?php $tmp1 = Arr::path($value, 'is_template', 0); if($tmp1 == 1){ echo 'value="1" checked';}else{echo 'value="0"';}?> data-id="1" type="checkbox" class="minimal">
        </td>
        <td><input name="integrations[<?php echo $index;?>][column]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($value, 'column', ''), ENT_QUOTES);?>"></td>
        <td><input name="integrations[<?php echo $index;?>][default]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($value, 'default', ''), ENT_QUOTES);?>"></td>
        <td><input name="integrations[<?php echo $index;?>][formula]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($value, 'formula', ''), ENT_QUOTES);?>"></td>
        <td>
            <input name="integrations[<?php echo $index;?>][is_check]" <?php $tmp1 = Arr::path($value, 'is_check', 0); if($tmp1 == 1){ echo 'value="1" checked';}else{echo 'value="0"';}?> data-id="1" type="checkbox" class="minimal">
        </td>
        <td>
            <input name="integrations[<?php echo $index;?>][is_join_horizontal]" <?php $tmp1 = Arr::path($value, 'is_join_horizontal', 0); if($tmp1 == 1){ echo 'value="1" checked';}else{echo 'value="0"';}?> data-id="1" type="checkbox" class="minimal">
         </td>
        <td>
            <input name="integrations[<?php echo $index;?>][join_level_vertical]" type="text" class="form-control" placeholder="Сколько уровней" value="<?php echo htmlspecialchars(Arr::path($value, 'join_level_vertical', ''), ENT_QUOTES);?>">
        </td>
        <td>
            <input name="integrations[<?php echo $index;?>][is_replace]" <?php $tmp1 = Arr::path($value, 'is_replace', 0); if($tmp1 == 1){ echo 'value="1" checked';}else{echo 'value="0"';}?> data-id="1" type="checkbox" class="minimal">
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="#" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
<?php }?>