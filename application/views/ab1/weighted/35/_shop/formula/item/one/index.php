<tr>
    <td>
        <select data-action="calc"  name="shop_formula_items[<?php echo $data->id; ?>][shop_material_id]" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php
            $s = 'data-id="'.$data->values['shop_material_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/material/list/list']);
            ?>
        </select>
    </td>
    <td>
        <input data-type="money" data-action="calc" name="shop_formula_items[<?php echo $data->id; ?>][norm]" type="text" class="form-control" placeholder="Норма" required value="<?php echo Func::getNumberStr($data->values['norm'], FALSE); ?>">
    </td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li class="tr-remove"><a href="" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>
