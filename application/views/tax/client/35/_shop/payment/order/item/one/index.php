<tr>
    <td>
        <div class="box-typeahead">
            <input data-name="iin" name="shop_payment_order_items[<?php echo $data->id; ?>][shop_worker_iin]" data-validation="length" data-validation-length="12" maxlength="12"  class="form-control workers_iin typeahead" placeholder="ИИН" type="text" value="<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_worker_id.iin', ''); ?>">
        </div>
    </td>
    <td>
        <div class="box-typeahead">
            <input data-name="name" name="shop_payment_order_items[<?php echo $data->id; ?>][shop_worker_name]" data-validation="length" data-validation-length="max250" maxlength="250"  class="form-control workers_name typeahead" placeholder="ФИО" type="text" value="<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_worker_id.name', ''); ?>">
        </div>
    </td>
    <td>
        <input data-name="date_of_birth" name="shop_payment_order_items[<?php echo $data->id; ?>][shop_worker_date_of_birth]" class="form-control valid" type="datetime" autocomplete="off" value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_worker_id.date_of_birth', '')); ?>">
    </td>
    <td>
        <input name="shop_payment_order_items[<?php echo $data->id; ?>][date]" data-validation="length" data-validation-length="6" maxlength="6" class="form-control valid" placeholder="012018" type="text" value="<?php echo str_replace('.', '', Func::str_replace_once('01.', '', Helpers_DateTime::getDateFormatRus($data->values['date']))); ?>">
    </td>
    <td>
        <input data-action="sum_amount" name="shop_payment_order_items[<?php echo $data->id; ?>][amount]" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control money-format valid" type="text" value="<?php echo Func::getNumberStr($data->values['amount'], FALSE); ?>">
    </td>
    <td>
        <button type="button" class="close" aria-label="Close" data-action="tr-delete">
            <span aria-hidden="true" class="fa fa-close"></span>
        </button>
    </td>
</tr>