<tr>
    <td data-id="index" class="text-right">$index$</td>
    <td>
        <select data-id="shop_product_id" data-type="select2" name="shop_production_items[<?php echo $data->id; ?>][shop_product_id]" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php
            $s = 'data-id="'.$data->values['shop_product_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/product/list/list']);
            ?>
        </select>
    </td>
    <td>
        <select data-id="shop_production_id" data-type="select2" name="shop_production_items[<?php echo $data->id; ?>][shop_production_id]" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php
            $s = 'data-id="'.$data->values['shop_production_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/production/list/list']);
            ?>
        </select>
    </td>
    <td>
        <input name="shop_production_items[<?php echo $data->id; ?>][coefficient]" type="text" class="form-control" placeholder="Коэффициент" required value="<?php echo $data->values['coefficient']; ?>">
    </td>
    <td class="text-center">
        <ul class="list-inline tr-button delete">
            <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>