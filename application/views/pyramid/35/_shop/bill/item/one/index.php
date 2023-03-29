<tr id="bill-item-<?php echo $data->values['id']; ?>">
    <td data-id="shop_room_id">
        <input name="shop_bill_items[<?php echo $data->values['id']; ?>][shop_room_id]" style="display: none" value="<?php echo $data->values['shop_room_id']; ?>">
        <span><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_room_id.name', ''); ?> (<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_room_id.human', ''); ?> + <?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_room_id.human_extra', ''); ?>)</span>
    </td>
    <td>
        <input data-id="date_from" name="shop_bill_items[<?php echo $data->values['id']; ?>][date_from]" class="form-control" type="text" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_from']); ?>" readonly>
    </td>
    <td>
        <input data-id="date_to" name="shop_bill_items[<?php echo $data->values['id']; ?>][date_to]" class="form-control" type="text" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_to']); ?>"  readonly>
    </td>
    <td data-id="diff"><?php echo Helpers_DateTime::diffDays($data->values['date_to'], $data->values['date_from']); ?></td>
    <td data-id="human"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_room_id.human', ''); ?></td>
    <td>
        <select data-id="human_extra" data-price="<?php echo Func::getNumberStr($data->values['price_extra'], FALSE); ?>" name="shop_bill_items[<?php echo $data->values['id']; ?>][human_extra]" class="form-control ks-select" data-parent="##panel#" style="width: 100%">
            <?php for($i = 0; $i <= intval(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_room_id.human_extra', 0)); $i++){ ?>
                <option value="<?php echo $i;?>" data-id="<?php echo $i;?>" <?php if($i == $data->values['human_extra']){echo 'selected';} ?>><?php echo $i;?></option>
            <?php } ?>
        </select>
    </td>
    <td data-id="price_extra" <?php if($data->values['human_extra'] == 0){echo 'style="color: #fff"';} ?>><?php echo Func::getNumberStr($data->values['price_extra'], FALSE); ?></td>
    <td>
        <select data-id="child_extra" data-price="<?php echo Func::getNumberStr($data->values['child_extra'], FALSE); ?>" name="shop_bill_items[<?php echo $data->values['id']; ?>][child_extra]" class="form-control ks-select" data-parent="##panel#" style="width: 100%">
            <?php for($i = 0; $i <= intval(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_room_id.human_extra', 0)); $i++){ ?>
                <option value="<?php echo $i;?>" data-id="<?php echo $i;?>" <?php if($i == $data->values['child_extra']){echo 'selected';} ?>><?php echo $i;?></option>
            <?php } ?>
        </select>
    </td>
    <td data-id="price_child" <?php if($data->values['child_extra'] == 0){echo 'style="color: #fff"';} ?>><?php echo Func::getNumberStr($data->values['price_child'], FALSE); ?></td>
    <td data-id="amount"
        data-amount="<?php echo $data->values['amount'] - (($data->values['price_extra'] * $data->values['human_extra'] + $data->values['price_child'] * $data->values['child_extra']) * $data->values['days']); ?>"
        data-amount-tr="<?php echo $data->values['amount']; ?>">
        <?php echo Func::getNumberStr($data->values['amount'], FALSE); ?>
    </td>
    <td>
        <input data-id="price" name="shop_bill_items[<?php echo $data->values['id']; ?>][price]" value="0" style="display: none">
        <input data-id="id" name="shop_bill_items[<?php echo $data->values['id']; ?>][id]" value="<?php echo $data->values['id']; ?>" style="display: none">
        <input data-id="amount-input" name="shop_bill_items[<?php echo $data->values['id']; ?>][amount]" value="<?php echo $data->values['amount']; ?>" style="display: none">
        <button type="button" class="close" aria-label="Close" data-action="tr-delete-free">
            <span aria-hidden="true" class="fa fa-close"></span>
        </button>
    </td>
</tr>