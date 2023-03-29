<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<tr>
    <td>
        <select data-action="calc-addition-service"  name="shop_addition_service_items[<?php echo $data->id; ?>][shop_product_id]" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php
            $s = 'data-id="'.$data->values['shop_product_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/product/list/addition-service']);
            ?>
        </select>
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" data-action="calc-addition-service" name="shop_addition_service_items[<?php echo $data->id; ?>][quantity]" type="text" class="form-control" placeholder="Кол-во" required value="<?php echo Func::getNumberStr($data->values['quantity'], FALSE, 3); ?>">
    </td>
    <td><input data-type="money" data-fractional-length="2" data-amount="<?php echo Arr::path($data->values, 'amount', ''); ?>" name="shop_addition_service_items[<?php echo $data->id; ?>][amount]" data-id="amount" disabled type="text" class="form-control" value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'amount', ''), FALSE);?>"></td>
    <td>
        <div class="btn-group" id="attorney">
            <input id="shop_client_attorney_id" name="shop_client_attorney_id" value="<?php echo $data->values['shop_client_attorney_id']; ?>" style="display: none;">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?php
                $attorney = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_attorney_id', '');

                $client = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id', '');
                $amountCash = Arr::path($client, 'balance_cache', '0');
                if (empty($attorney)){
                    echo 'Наличными';
                    echo '<br><span class="text-red"> Остаток: <b style="font-size: 18px;">'.Func::getPriceStr($siteData->currency, $amountCash).' </b></span>';
                }else{
                    echo Arr::path($attorney, 'name', '').'<br><span class="text-red"> Остаток: <b style="font-size: 18px;">'.Func::getPriceStr($siteData->currency, Arr::path($attorney, 'balance', '0')).' </b></span>';
                }
                ?> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu" style="max-height: 309px;overflow-y: auto;">
                <li>
                    <a href="#" data-id="0" data-amount="<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.balance_cache', ''); ?>">
                        Наличные<?php
                        echo '<br><span class="text-red"> Остаток: <b style="font-size: 18px;">'.Func::getPriceStr($siteData->currency, $amountCash).' </b></span>';
                        ?>
                    </a>
                </li>
                <?php echo $siteData->globalDatas['view::_shop/client/attorney/list/list']; ?>
            </ul>
        </div>
    </td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li class="tr-remove"><a href="" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>
