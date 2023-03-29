<tr>
    <td>
        <select name="shop_competitor_price_items[<?php echo $data->id; ?>][shop_product_id]" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php
            $s = 'data-id="'.$data->values['shop_product_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/product/list/list']);
            ?>
        </select>
    </td>
    <td>
        <input data-type="money" data-fractional-length="2" name="shop_competitor_price_items[<?php echo $data->id; ?>][price]" type="text" class="form-control" placeholder="Цена" required value="<?php echo Func::getNumberStr($data->values['price'], FALSE); ?>">
    </td>
    <td>
        <input data-type="money" data-fractional-length="2" name="shop_competitor_price_items[<?php echo $data->id; ?>][delivery]" type="text" class="form-control" placeholder="Доставка" required value="<?php echo Func::getNumberStr($data->values['delivery'], FALSE); ?>">
    </td>
    <td>
        <input data-type="money" data-fractional-length="2" name="shop_competitor_price_items[<?php echo $data->id; ?>][delivery_zhd]" type="text" class="form-control" placeholder="Доставка ЖД" required value="<?php echo Func::getNumberStr($data->values['delivery_zhd'], FALSE); ?>">
    </td>
    <td>
        <input data-type="money" data-fractional-length="2" name="shop_competitor_price_items[<?php echo $data->id; ?>][product_capacity]" type="text" class="form-control" placeholder="Производственная мощность" required value="<?php echo htmlspecialchars($data->values['product_capacity'], ENT_QUOTES); ?>">
    </td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li class="tr-remove"><a href="" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>
