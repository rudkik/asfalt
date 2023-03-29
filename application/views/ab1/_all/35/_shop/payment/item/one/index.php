<?php $isShow = !$siteData->operation->getIsAdmin() && Request_RequestParams::getParamBoolean('is_show'); ?>
<tr>
    <td>
        <?php if($isShow){ ?>
            <input name="shop_payment_items[<?php echo $data->id; ?>][shop_product_id]" value="<?php echo $data->values['shop_product_id']; ?>" style="display: none">
        <?php } ?>
        <select data-action="calc-payment-product" name="shop_payment_items[<?php echo $data->id; ?>][shop_product_id]" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Без значения</option>
            <?php
            $s = 'data-id="'.$data->values['shop_product_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/product/list/list']);
            ?>
        </select>
    </td>
    <td>
        <input data-type="money" data-fractional-length="2" data-action="calc-payment" data-id="price" name="shop_payment_items[<?php echo $data->id; ?>][price]" type="text" class="form-control" placeholder="Цена" required value="<?php echo Func::getNumberStr($data->values['price'], true, 2, true); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" data-action="calc-payment" data-id="quantity" name="shop_payment_items[<?php echo $data->id; ?>][quantity]" type="text" class="form-control" placeholder="Кол-во" required value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3, true); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </td>
    <td><input data-type="money" data-fractional-length="2" data-action="amount-edit" data-amount="<?php echo Arr::path($data->values, 'amount', ''); ?>" name="shop_payment_items[<?php echo $data->id; ?>][amount]" data-id="amount" disabled type="text" class="form-control" value="<?php echo Func::getNumberStr(Arr::path($data->values, 'amount', ''), true, 2, true);?>"></td>
    <?php if(!$isShow){?>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li class="tr-remove"><a href="" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
    <?php } ?>
</tr>
