<tr>
    <td>
        <select data-id="shop_room_id" name="shop_payment_items[<?php echo $data->id; ?>][shop_room_id]" class="form-control ks-select" data-parent="##parent-select#" style="width: 100%">
            <?php
            $tmp = 'data-id="'.$data->values['shop_room_id'].'"';
            echo str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/room/list/list']);
            ?>
        </select>
    </td>
    <td>
        <input data-id="date_from" name="shop_payment_items[<?php echo $data->id; ?>][date_from]" class="form-control" type="datetime" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_from']); ?>">
    </td>
    <td>
        <input data-id="date_to" name="shop_payment_items[<?php echo $data->id; ?>][date_to]" class="form-control" type="datetime" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_to']); ?>" >
    </td>
    <td data-id="price"><?php echo Func::getNumberStr($data->values['price'], FALSE); ?></td>
    <td>
        <input data-id="human_extra" name="shop_payment_items[<?php echo $data->id; ?>][human_extra]" class="form-control" type="text" value="<?php echo $data->values['human_extra']; ?>"
               data-total="<?php echo Func::getNumberStr($data->values['amount'], FALSE); ?>"
               data-amount="<?php echo Func::getNumberStr($data->values['price'] * (Helpers_DateTime::diffDays($data->values['date_to'], $data->values['date_from'])), FALSE); ?>"
               data-price="<?php echo Func::getNumberStr($data->values['price_extra'], FALSE); ?>">
    </td>
    <td data-id="price_extra"><?php echo Func::getNumberStr($data->values['price_extra'], FALSE); ?></td>
    <td>
        <input data-id="child_extra" name="shop_payment_items[<?php echo $data->id; ?>][child_extra]" class="form-control" type="text" value="<?php echo $data->values['child_extra']; ?>"
               data-total="<?php echo Func::getNumberStr($data->values['amount'], FALSE); ?>"
               data-amount="<?php echo Func::getNumberStr($data->values['price'] * (Helpers_DateTime::diffDays($data->values['date_to'], $data->values['date_from'])), FALSE); ?>"
               data-price="<?php echo Func::getNumberStr($data->values['price_child'], FALSE); ?>">
    </td>
    <td data-id="price_child"><?php echo Func::getNumberStr($data->values['price_child'], FALSE); ?></td>
    <td data-id="amount"><?php echo Func::getNumberStr($data->values['amount'], FALSE); ?></td>
    <td>
        <button type="button" class="close" aria-label="Close" data-action="tr-delete-free">
            <span aria-hidden="true" class="fa fa-close"></span>
        </button>
    </td>
</tr>