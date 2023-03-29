<?php $isBlock = $data->values['block_amount'] > 0.0001; ?>
<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<tr>
    <td>
        <?php if($isShow || $isBlock){?><input name="shop_delivery_discount_items[<?php echo $data->id; ?>][delivery_shop_branch_id]" value="<?php echo $data->values['delivery_shop_branch_id'];?>" style="display: none;"><?php } ?>
        <select data-id="delivery_shop_branch_id" name="shop_delivery_discount_items[<?php echo $data->id; ?>][delivery_shop_branch_id]" class="form-control select2" style="width: 100%" <?php if($isShow || $isBlock){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Все</option>
            <?php
            $tmp = 'data-id="'.$data->values['delivery_shop_branch_id'].'"';
            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/branch/list/list']));
            ?>
        </select>
    </td>
    <td>
        <?php if($isShow || $isBlock){?><input name="shop_delivery_discount_items[<?php echo $data->id; ?>][shop_delivery_rubric_id]" value="<?php echo $data->values['shop_delivery_rubric_id'];?>" style="display: none;"><?php } ?>
        <select data-id="shop_delivery_rubric_id" name="shop_delivery_discount_items[<?php echo $data->values['id'];?>][shop_delivery_rubric_id]" class="form-control select2" style="width: 100%" <?php if($isShow){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Все</option>
            <?php
            $s = 'data-id="'.$data->values['shop_delivery_rubric_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/delivery/rubric/list/list']);
            ?>
        </select>
    </td>
    <td>
        <?php if($isShow || $isBlock){?><input name="shop_delivery_discount_items[<?php echo $data->id; ?>][shop_delivery_id]" value="<?php echo $data->values['shop_delivery_id'];?>" style="display: none;"><?php } ?>
        <select data-id="shop_delivery_id" name="shop_delivery_discount_items[<?php echo $data->values['id'];?>][shop_delivery_id]" class="form-control select2" style="width: 100%" <?php if($isShow){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Все</option>
            <?php
            $s = 'data-id="'.$data->values['shop_delivery_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/delivery/list/list']);
            ?>
        </select>
    </td>
    <td>
        <input data-type="money" data-fractional-length="2" name="shop_delivery_discount_items[<?php echo $data->values['id'];?>][discount]" type="text" class="form-control" placeholder="Скидка" value="<?php echo $data->values['discount']; ?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </td>
    <td>
        <input data-type="money" data-fractional-length="2" name="shop_delivery_discount_items[<?php echo $data->id; ?>][amount]" type="text" class="form-control" placeholder="Сумма" data-amount="<?php echo $data->values['amount']; ?>" value="<?php echo Func::getNumberStr($data->values['amount'], TRUE); ?>"  <?php if($isShow){ ?>readonly<?php } ?>>
    </td>
    <td class="text-right">
        <a href="<?php echo Func::getFullURL($siteData, '/shopcaritem/delivery_price', array(), array('shop_delivery_price_id' => $data->id), $data->values); ?>"><?php echo Func::getNumberStr($data->values['block_amount'], TRUE, 2, FALSE); ?></a>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['balance_amount'], TRUE, 2, FALSE); ?>
    </td>
    <?php if(!$isShow){ ?>
    <td>
        <?php if(!$isBlock){?>
            <ul class="list-inline tr-button delete">
                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        <?php }?>
    </td>
    <?php } ?>
</tr>