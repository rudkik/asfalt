<tr>
    <td>
        <div class="box-typeahead">
            <input name="shop_worker_wages[<?php echo $data->id; ?>][shop_worker_name]" class="form-control workers_name typeahead" placeholder="ФИО сотрудника" type="text" value="<?php echo Arr::path($data->values, 'name', ''); ?>">
        </div>
    </td>
    <td>
        <select name="shop_worker_wages[<?php echo $data->id; ?>][worker_status_id]" class="form-control ks-select" data-parent="##parent-select#" style="width: 100%">
            <option value="0" data-id="0">Без статуса</option>
            <?php
            $s = 'data-id="'.Arr::path($data->values, 'worker_status_id', '').'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::workerstatus/list/list']);
            ?>
        </select>
    </td>
    <td>
        <input name="shop_worker_wages[<?php echo $data->id; ?>][1]" class="form-control money-format" type="text" value="<?php echo Arr::path($data->values, '1', ''); ?>">
    </td>
    <td>
        <input name="shop_worker_wages[<?php echo $data->id; ?>][2]" class="form-control money-format" type="text" value="<?php echo Arr::path($data->values, '2', ''); ?>">
    </td>
    <td>
        <input name="shop_worker_wages[<?php echo $data->id; ?>][3]" class="form-control money-format" type="text" value="<?php echo Arr::path($data->values, '3', ''); ?>">
    </td>
    <td>
        <input name="shop_worker_wages[<?php echo $data->id; ?>][4]" class="form-control money-format" type="text" value="<?php echo Arr::path($data->values, '4', ''); ?>">
    </td>
    <td>
        <input name="shop_worker_wages[<?php echo $data->id; ?>][5]" class="form-control money-format" type="text" value="<?php echo Arr::path($data->values, '5', ''); ?>">
    </td>
    <td>
        <input name="shop_worker_wages[<?php echo $data->id; ?>][6]" class="form-control money-format" type="text" value="<?php echo Arr::path($data->values, '6', ''); ?>">
    </td>
    <td>
        <button type="button" class="close" aria-label="Close" data-action="tr-delete">
            <span aria-hidden="true" class="fa fa-close"></span>
        </button>
    </td>
</tr>