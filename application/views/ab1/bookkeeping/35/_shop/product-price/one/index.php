<?php $isNotEdit = Request_RequestParams::getParamBoolean('is_show') || $data->values['block_amount'] > 0.0001; ?>
<tr>
    <td>
        <select data-id="shop_product_rubric_id" name="shop_pricelist_items[<?php echo $data->values['id'];?>][shop_product_rubric_id]" class="form-control select2" style="width: 100%">
            <option value="0" data-id="0">Все</option>
            <?php
            $s = 'data-id="'.$data->values['shop_product_rubric_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/product/rubric/list/list']);
            ?>
        </select>
    </td>
    <td>
        <select data-id="shop_product_id" name="shop_pricelist_items[<?php echo $data->values['id'];?>][shop_product_id]" class="form-control select2" style="width: 100%">
            <option value="0" data-id="0">Все</option>
            <?php
            $s = 'data-id="'.$data->values['shop_product_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/product/list/list']);
            ?>
        </select>
    </td>
    <td>
        <input data-type="money" data-fractional-length="2" name="shop_pricelist_items[<?php echo $data->values['id'];?>][discount]" type="text" class="form-control" placeholder="Скидка" value="<?php echo $data->values['discount']; ?>">
    </td>
    <td>
        <input data-type="money" data-fractional-length="2" name="shop_pricelist_items[<?php echo $data->id; ?>][amount]" type="text" class="form-control" placeholder="Сумма" data-amount="<?php echo $data->values['amount']; ?>" value="<?php echo Func::getNumberStr($data->values['amount'], TRUE); ?>">
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['block_amount'], TRUE, 2, FALSE); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['balance_amount'], TRUE, 2, FALSE); ?>
    </td>
    <td>
        <?php if(!$isNotEdit){?>
            <ul class="list-inline tr-button delete">
                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        <?php }?>
    </td>
</tr>