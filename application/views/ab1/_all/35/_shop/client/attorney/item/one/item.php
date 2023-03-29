<?php $isShow = Request_RequestParams::getParamBoolean('is_show'); ?>
<?php if($data->values['shop_product_rubric_id'] == 0 && $data->values['shop_product_id'] == 0){ ?>
    <tr>
        <td colspan="4">
            На сумму
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" data-id="amount" name="shop_client_attorney_items[<?php echo $data->id; ?>][amount]" type="text" class="form-control" data-amount="<?php echo $data->values['amount']; ?>" placeholder="Сумма" value="<?php echo Func::getNumberStr($data->values['amount'], TRUE); ?>">
        </td>
        <td>
            <?php if(!$isShow){?>
                <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
                    <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                </ul>
            <?php }?>
        </td>
    </tr>
<?php }else{ ?>
    <tr>
        <td>
            <select data-id="shop_product_rubric_id" name="shop_client_attorney_items[<?php echo $data->id; ?>][shop_product_rubric_id]" class="form-control select2" style="width: 100%" <?php if($isShow){ ?>disabled<?php } ?>>
                <option value="0" data-id="0">Все</option>
                <?php
                $tmp = 'data-id="'.$data->values['shop_product_rubric_id'].'"';
                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/product/rubric/list/list']));
                ?>
            </select>
        </td>
        <td>
            <select data-id="shop_product_id" name="shop_client_attorney_items[<?php echo $data->id; ?>][shop_product_id]" class="form-control select2" style="width: 100%" <?php if($isShow){ ?>disabled<?php } ?>>
                <option value="0" data-id="0">Все</option>
                <?php
                $tmp = 'data-id="'.$data->values['shop_product_id'].'"';
                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/product/list/list']));
                ?>
            </select>
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" data-id="quantity" name="shop_client_attorney_items[<?php echo $data->id; ?>][quantity]" type="text" class="form-control" placeholder="Кол-во" value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>" <?php if($isShow){echo 'readonly';}?>>
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" data-id="price" name="shop_client_attorney_items[<?php echo $data->id; ?>][price]" type="text" class="form-control" placeholder="Цена" value="<?php echo Func::getNumberStr($data->values['price'], FALSE); ?>" <?php if($isShow){echo 'readonly';}?>>
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" data-id="amount" name="shop_client_attorney_items[<?php echo $data->id; ?>][amount]" type="text" class="form-control" data-amount="<?php echo $data->values['amount']; ?>" placeholder="Сумма" value="<?php echo Func::getNumberStr($data->values['amount'], TRUE); ?>" readonly>
        </td>
        <?php if(!$isShow){?>
            <td>
                <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
                    <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                </ul>
            </td>
        <?php }?>
    </tr>
<?php }?>
