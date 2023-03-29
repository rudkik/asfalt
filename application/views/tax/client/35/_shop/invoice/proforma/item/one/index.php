<tr>
    <td>
        <div class="box-typeahead">
            <input data-name="name" name="shop_invoice_items[<?php echo $data->id; ?>][shop_product_name]" class="form-control products typeahead" placeholder="Товар/услуга" type="text" value="<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name', ''); ?>">
        </div>
    </td>
    <td class="td-check">
        <label class="custom-control custom-checkbox">
            <input data-name="is_service" name="shop_invoice_items[<?php echo $data->id; ?>][is_service]" type="checkbox" class="custom-control-input" value="1" <?php if (Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.is_service', '') == 1){echo 'checked';} ?>>
            <span class="custom-control-indicator"></span>
        </label>
    </td>
    <td>
        <input data-name="unit" name="shop_invoice_items[<?php echo $data->id; ?>][unit_name]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" type="text" value="<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.unit_id.name', $data->values['unit_name']); ?>">
    </td>
    <td>
        <input data-action="tr-calc-amount" data-decimals="3" data-id="quantity" name="shop_invoice_items[<?php echo $data->id; ?>][quantity]" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control money-format valid" type="text" value="<?php echo floatval($data->values['quantity']); ?>">
    </td>
    <td>
        <input data-name="price" data-decimals="2" data-action="tr-calc-amount" data-id="price" name="shop_invoice_items[<?php echo $data->id; ?>][price]" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control money-format valid" placeholder="Цена" type="text" value="<?php echo $data->values['price']; ?>">
    </td>
    <td data-id="amount" data-total="#invoice-proforma-new-amount" data-amount="<?php echo $data->values['amount']; ?>"><?php echo Func::getNumberStr($data->values['amount']); ?></td>
    <td>
        <button type="button" class="close" aria-label="Close" data-action="tr-delete">
            <span aria-hidden="true" class="fa fa-close"></span>
        </button>
    </td>
</tr>