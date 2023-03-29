<?php $isShow = Request_RequestParams::getParamBoolean('is_show'); ?>
<tr>
    <td>
        <?php if($isShow){?><input name="shop_client_contract_items[<?php echo $data->id; ?>][fuel_id]" value="<?php echo $data->values['fuel_id'];?>" style="display: none;"><?php }?>
        <select data-id="fuel_id" name="shop_client_contract_items[<?php echo $data->id; ?>][fuel_id]" class="form-control select2" style="width: 100%" <?php if($isShow){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Выберите значение</option>
            <?php
            $tmp = 'data-id="'.$data->values['fuel_id'].'"';
            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::fuel/list/list']));
            ?>
        </select>
    </td>
    <td>л</td>
    <td>
        <input data-type="money" data-fractional-length="3" data-id="quantity" name="shop_client_contract_items[<?php echo $data->id; ?>][quantity]" type="text" class="form-control" placeholder="Кол-во" value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </td>
    <td>
        <input data-type="money" data-fractional-length="2" data-id="price" name="shop_client_contract_items[<?php echo $data->id; ?>][price]" type="text" class="form-control" placeholder="Цена" value="<?php echo Func::getNumberStr($data->values['price'], FALSE); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </td>
    <td>
        <input data-type="money" data-fractional-length="2" data-id="amount" name="shop_client_contract_items[<?php echo $data->id; ?>][amount]" type="text" class="form-control" placeholder="Сумма" data-amount="<?php echo $data->values['amount']; ?>" value="<?php echo Func::getNumberStr($data->values['amount'], TRUE); ?>" readonly>
    </td>
    <td>
        <?php if(!$isShow){?>
            <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        <?php }?>
    </td>
</tr>