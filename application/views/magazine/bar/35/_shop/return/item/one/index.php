<tr data-action="tr">
    <td data-id="index" class="text-right">$index$</td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['created_at']); ?></td>
    <td>
        <span data-id="shop_product_name"><?php echo $data->getElementValue('shop_product_id'); ?></span>
        <input data-id="shop_product_id" name="shop_return_items[<?php echo $data->id; ?>][shop_product_id]" value="<?php echo $data->values['shop_product_id']; ?>" hidden>
    </td>
    <td>
        <input data-action="tr-multiply" data-total="#total" data-parent-count="2" name="shop_return_items[<?php echo $data->id; ?>][price]" type="tel" class="form-control money-format text-right" placeholder="Цена" value="<?php echo $data->values['price']; ?>" required>
    </td>
    <td>
        <div class="input-group">
            <div class="input-group-btn">
                <button data-action="count-plus" data-value="-1" data-count="count" data-parent-count="2" type="button" class="btn bg-green btn-flat">-</button>
            </div>
            <input data-id="count" data-action="tr-multiply" data-total="#total" data-parent-count="3" name="shop_return_items[<?php echo $data->id; ?>][quantity]" type="tel" class="form-control text-center" placeholder="Кол-во" required value="<?php echo $data->values['quantity']; ?>">
            <div class="input-group-btn">
                <button data-action="count-plus"data-count="count" data-parent-count="2" type="button" class="btn bg-green btn-flat">+</button>
            </div>
        </div>
    </td>
    <td data-id="total" class="text-right" value="<?php echo $data->values['amount']; ?>"><?php echo Func::getNumberStr($data->values['amount'], TRUE); ?></td>
    <td class="text-center">
        <ul class="list-inline tr-button delete">
            <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>