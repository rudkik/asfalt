<?php $isShow = Request_RequestParams::getParamBoolean('is_show'); ?>
<tr data-barcode="<?php echo $data->getElementValue('shop_production_id', 'barcode'); ?>" data-action="tr">
    <td data-id="index" class="text-right">#index#</td>
    <td>
        <a target="_blank" href="/bar/shopproduction/edit?id=<?php echo $data->values['shop_production_id']; ?>">
            <span data-id="shop_product_name"><?php echo $data->getElementValue('shop_production_id'); ?></span>
        </a>
        <br><?php echo $data->getElementValue('shop_production_id', 'barcode'); ?>
        <input data-id="shop_production_id" name="shop_realization_items[<?php echo $data->id; ?>][shop_production_id]" value="<?php echo $data->values['shop_production_id']; ?>" hidden>
    </td>
    <td class="text-center">
        <div class="box-quantity">
            <input data-round="1" data-keywords="virtual" data-id="quantity" data-keywords="virtual" data-action="tr-multiply" data-total="#total" data-parent-count="3" name="shop_realization_items[<?php echo $data->id; ?>][quantity]" type="tel" class="form-control text-center" placeholder="Кол-во" required value="<?php echo Func::getNumberStr($data->values['quantity'], FALSE, 3); ?>" <?php if($isShow){ ?>readonly<?php }?>>
        </div>
        <div class="box-price">
            <input data-round="1" data-keywords="virtual" data-id="price_average" data-keywords="virtual" data-action="tr-multiply" data-parent-count="3" name="shop_realization_items[<?php echo $data->id; ?>][price]" type="tel" class="form-control text-center" placeholder="Цена" required value="<?php echo Func::getNumberStr($data->values['price'], FALSE, 2); ?>" <?php if($isShow){ ?>readonly<?php }?>>
        </div>
    </td>
    <td data-id="total" class="text-right" value="<?php echo $data->values['amount']; ?>">
        <?php echo Func::getNumberStr($data->values['amount'], TRUE); ?>
        <input name="shop_realization_items[<?php echo $data->id; ?>][id]" value="<?php echo $data->id; ?>" style="display: none">
    </td>
    <?php if(!$isShow){ ?>
        <td class="text-center">
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    <?php }?>
</tr>