<tr>
    <td>
        <select name="shop_worker_wages[<?php echo $data->id; ?>][shop_worker_id]" class="form-control ks-select" data-parent="##parent-select#" style="width: 100%">
            <option value="0" data-id="0">Выберите сотрудника</option>
            <?php
            $s = 'data-id="'.$data->values['shop_worker_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/worker/list/list']);
            ?>
        </select>
    </td>
    <td>
        <select name="shop_worker_wages[<?php echo $data->id; ?>][worker_status_id]" class="form-control ks-select" data-parent="##parent-select#" style="width: 100%">
            <option value="0" data-id="0">Без статуса</option>
            <?php
            $s = 'data-id="'.$data->values['worker_status_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::workerstatus/list/list']);
            ?>
        </select>
    </td>
    <td>
        <input name="shop_worker_wages[<?php echo $data->id; ?>][wage]" class="form-control money-format" type="text" value="<?php echo $data->values['wage']; ?>">
    </td>
    <td>
        <input name="shop_worker_wages[<?php echo $data->id; ?>][is_owner]" class="form-control" type="checkbox" value="1" <?php if($data->values['is_owner']){echo 'checked';} ?>>
    </td>
    <td>
        <button type="button" class="close" aria-label="Close" data-action="tr-delete">
            <span aria-hidden="true" class="fa fa-close"></span>
        </button>
    </td>
</tr>