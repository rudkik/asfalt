<tr>
    <td>
        <select name="shop_plan_items[<?php echo $data->id; ?>][shop_product_id]" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php
            $s = 'data-id="'.$data->values['shop_product_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/product/list/list']);
            ?>
        </select>
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" name="shop_plan_items[<?php echo $data->id; ?>][quantity]" type="text" class="form-control" placeholder="Кол-во" required value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>">
    </td>
    <td>
        <select  name="shop_plan_items[<?php echo $data->id; ?>][working_shift]" class="form-control select2" required style="width: 100%;">
            <?php
            $s = 'data-id="'.$data->values['working_shift'].'"';
            echo str_replace($s, $s.' selected', '<option value="1" data-id="1">1 смена</option><option value="2" data-id="2">2 смена</option>');
            ?>
        </select>
    </td>
    <td>
        <select  name="shop_plan_items[<?php echo $data->id; ?>][shop_turn_place_id]" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php
            $s = 'data-id="'.$data->values['shop_turn_place_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/turn/place/list/list']);
            ?>
        </select>
    </td>
    <td>
        <ul class="list-inline tr-button delete">
            <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>
