<tr data-barcode="<?php echo $data->values['barcode']; ?>" data-action="tr">
    <td data-id="index" class="text-right">$index$</td>
    <td>
        <a target="_blank" href="/accounting/shopproduct/history?shop_product_id=<?php echo $data->values['id']; ?>">
            <span data-id="shop_product_name"><?php echo $data->values['name']; ?></span>
        </a><br>
        <?php echo $data->values['barcode']; ?>
        <input data-id="shop_product_id" name="shop_revise_items[<?php echo $data->id; ?>][shop_product_id]" value="<?php echo $data->values['id']; ?>" hidden>
    </td>
    <td>
        <div class="input-group">
            <div class="input-group-btn">
                <button data-action="count-plus" data-value="-1" data-count="count" data-parent-count="4" type="button" class="btn bg-green btn-flat">-</button>
            </div>
            <input data-parent-count="3" data-action="diff" data-id="count" name="shop_revise_items[<?php echo $data->id; ?>][quantity_actual]" type="text" class="form-control text-center" placeholder="Кол-во" required value="0">
            <div class="input-group-btn">
                <button data-action="count-plus" data-count="count" data-parent-count="4" type="button" class="btn bg-green btn-flat">+</button>
            </div>
        </div>
    </td>
    <td data-id="quantity" class="text-right" value="<?php $quantity = $data->getElementValue('shop_product_stock_id', 'quantity_balance') * $data->values['coefficient_revise']; echo $quantity; ?>"><?php echo Func::getNumberStr($quantity, TRUE, 3, false);?></td>
    <td data-id="diff" class="text-bold text-right"><?php echo Func::getNumberStr($quantity * (-1), TRUE, 3, false); ?></td>
    <td class="text-center">
        <ul class="list-inline tr-button delete">
            <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>