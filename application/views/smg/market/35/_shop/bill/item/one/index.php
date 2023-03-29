<tr>
    <td>
        <select data-basic-url="market" data-type="select2" data-action="product" name="shop_bill_items[<?php echo $data->values['id']; ?>][shop_product_id]" class="form-control select2" required style="width: 100%;">
            <option value="<?php echo $data->values['shop_product_id']; ?>" data-id="<?php echo $data->values['shop_product_id']; ?>"><?php echo $data->getElementValue('shop_product_id'); ?></option>
        </select>
    </td>
    <td>
        <input data-action="price-edit" data-id="price" name="shop_bill_items[<?php echo $data->values['id']; ?>][price]" type="text" class="form-control" placeholder="Цена" required value="<?php echo $data->values['price']; ?>">
    </td>
    <td>
        <input data-action="quantity-edit" data-id="quantity" name="shop_bill_items[<?php echo $data->values['id']; ?>][quantity]" type="text" class="form-control" placeholder="Кол-во" required value="<?php echo $data->values['quantity']; ?>">
    </td>
    <td>
        <input data-id="amount" name="shop_bill_items[<?php echo $data->values['id']; ?>][amount]" type="text" class="form-control" readonly value="<?php echo $data->values['amount']; ?>">
    </td>
    <td>
        <input name="shop_bill_items[<?php echo $data->values['id']; ?>][commission_source]" type="text" class="form-control" placeholder="Коммисия источника" value="<?php echo $data->values['commission_source']; ?>">
    </td>
    <td>
        <ul class="list-inline tr-button delete">
            <li class="tr-remove"><a data-action="remove-tr" href="#" data-parent-count="4" class="link-red text-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>