<tr id="piece-<?php echo $data->id; ?>">
    <td>
        <select data-action="calc-piece"  name="shop_piece_items[<?php echo $data->id; ?>][shop_product_id]" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php
            $s = 'data-id="'.$data->values['shop_product_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/product/list/list']);
            ?>
        </select>
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" data-action="calc-piece" name="shop_piece_items[<?php echo $data->id; ?>][quantity]" type="text" class="form-control" placeholder="Кол-во" required value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>">
    </td>
    <td><input data-type="money" data-fractional-length="2" data-amount="<?php echo Arr::path($data->values, 'amount', ''); ?>" name="shop_piece_items[<?php echo $data->id; ?>][amount]" data-id="amount" disabled type="text" class="form-control" value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'amount', ''), FALSE);?>"></td>
    <td>
        <select data-action="shop_client_attorney" data-contract='#piece-<?php echo $data->id; ?> [data-id="shop_client_contract_id"]' data-product="#shop_delivery_id" data-id="shop_client_attorney_id" name="shop_piece_items[<?php echo $data->id; ?>][shop_client_attorney_id]"
                data-product-amount="<?php echo $data->values['amount']; ?>" data-attorney-id="<?php echo $data->values['shop_client_attorney_id']; ?>"
                data-amount="<?php echo $data->getElementValue('shop_client_attorney_id', 'balance', $data->getElementValue('shop_client_id', 'balance_cache', 0)); ?>"
                class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Наличными</option>
            <?php echo $siteData->globalDatas['view::_shop/client/attorney/list/option-balance']; ?>
        </select>
    </td>
    <td>
        <select data-action="shop_client_contract" data-id="shop_client_contract_id" name="shop_piece_items[<?php echo $data->id; ?>][shop_client_contract_id]" data-contract-id="<?php echo $data->values['shop_client_contract_id']; ?>" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без договора</option>
            <?php echo $siteData->globalDatas['view::_shop/client/contract/list/list']; ?>
        </select>
    </td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li class="tr-remove"><a href="" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>
