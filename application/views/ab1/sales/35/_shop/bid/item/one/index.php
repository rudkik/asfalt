<tr>
    <td>
        <select name="shop_bid_items[<?php echo $data->id; ?>][shop_product_id]" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php
            $s = 'data-id="'.$data->values['shop_product_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/product/list/list']);
            ?>
        </select>
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" name="shop_bid_items[<?php echo $data->id; ?>][quantity]" type="text" class="form-control" placeholder="Кол-во" required value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>">
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" name="shop_bid_items[<?php echo $data->id; ?>][delivery]" type="text" class="form-control" placeholder="Кол-во доставки" required value="<?php echo Func::getNumberStr($data->values['delivery'], true, 3); ?>">
    </td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li class="tr-remove"><a href="" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>
