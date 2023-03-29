<?php
$isShow = Request_RequestParams::getParamBoolean('is_show');
$isBlock = $data->values['block_amount'] > 0.0001 && $data->values['is_fixed_price'] == 1;
?>
<tr>
    <td>
        <?php if($isShow || $isBlock){?><input name="shop_client_contract_items[<?php echo $data->id; ?>][product_shop_branch_id]" value="<?php echo $data->values['product_shop_branch_id'];?>" style="display: none;"><?php } ?>
        <select data-id="product_shop_branch_id" name="shop_client_contract_items[<?php echo $data->id; ?>][product_shop_branch_id]" class="form-control select2" style="width: 100%" <?php if($isShow || $isBlock){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Все</option>
            <?php
            $tmp = 'data-id="'.$data->values['product_shop_branch_id'].'"';
            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/branch/list/list']));
            ?>
        </select>
    </td>
    <td>
        <?php if($isShow || $isBlock){?><input name="shop_client_contract_items[<?php echo $data->id; ?>][shop_product_rubric_id]" value="<?php echo $data->values['shop_product_rubric_id'];?>" style="display: none;"><?php } ?>
        <select data-id="shop_product_rubric_id" name="shop_client_contract_items[<?php echo $data->id; ?>][shop_product_rubric_id]" class="form-control select2" style="width: 100%" <?php if($isShow || $isBlock){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Все</option>
            <?php
            $tmp = 'data-id="'.$data->values['shop_product_rubric_id'].'"';
            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/product/rubric/list/list']));
            ?>
        </select>
    </td>
    <td>
        <?php if($isShow || $isBlock){?><input name="shop_client_contract_items[<?php echo $data->id; ?>][shop_product_id]" value="<?php echo $data->values['shop_product_id'];?>" style="display: none;"><?php }?>
        <select data-id="shop_product_id" name="shop_client_contract_items[<?php echo $data->id; ?>][shop_product_id]" class="form-control select2" style="width: 100%" <?php if($isShow || $isBlock){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Все</option>
            <?php
            $tmp = 'data-id="'.$data->values['shop_product_id'].'"';
            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/product/list/list']));
            ?>
        </select>
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" data-id="quantity" name="shop_client_contract_items[<?php echo $data->id; ?>][quantity]" type="text" class="form-control" placeholder="Кол-во" value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" data-id="price" name="shop_client_contract_items[<?php echo $data->id; ?>][price]" type="text" class="form-control" placeholder="Цена" value="<?php echo Func::getNumberStr($data->values['price'], true); ?>" <?php if($isShow || ($isBlock && $data->values['discount'] == 0)){ ?>readonly<?php } ?>>
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" data-id="amount" name="shop_client_contract_items[<?php echo $data->id; ?>][amount]" type="text" class="form-control" placeholder="Сумма" data-amount="<?php echo $data->values['amount']; ?>" value="<?php echo Func::getNumberStr($data->values['amount'], TRUE); ?>" readonly>
    </td>
    <td>
        <input name="shop_client_contract_items[<?php echo $data->id; ?>][discount]" type="text" class="form-control" placeholder="Скидка" value="<?php echo Func::getNumberStr($data->values['discount'], FALSE); ?>" <?php if($isShow || $isBlock){ ?>readonly<?php } ?>>
    </td>
    <td class="text-center">
        <input name="shop_client_contract_items[<?php echo $data->id; ?>][is_fixed_price]" data-id="1" <?php if ($data->values['is_fixed_price'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow || $isBlock){?>readonly<?php }?>  style="width: 20px;">
        <?php if($isShow || $isBlock){?>
            <input name="shop_client_contract_items[<?php echo $data->id; ?>][is_fixed_price]" value="1" style="display: none">
        <?php }?>
    </td>
    <td>
        <input name="shop_client_contract_items[<?php echo $data->id; ?>][from_at]" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['from_at']); ?>">
    </td>
    <?php if($data->values['block_amount'] > 0){ ?>
        <td class="text-right">
            <a data-id="block_amount" href="<?php echo Func::getFullURL($siteData, '/shopcaritem/invoice', array(), array('shop_client_contract_item_id' => $data->id), $data->values); ?>"><?php echo Func::getNumberStr($data->values['block_amount'], TRUE, 2, FALSE); ?></a>
            <br><a data-action="close-contract-item" href="#" class="link-red text-sm">Закрыть скидку</a>
        </td>
    <?php }else{ ?>
        <td data-id="block_amount" class="text-right">
            0.00
        </td>
    <?php } ?>
    <td data-id="balance"  class="text-right">
        <?php echo Func::getNumberStr($data->values['balance_amount'], TRUE, 2, FALSE); ?>
    </td>
    <td>
        <?php if(!$isShow && !$isBlock){?>
            <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        <?php }?>
    </td>
</tr>