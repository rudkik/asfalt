<tr>
    <td>
        <select data-id="shop_service_id" name="shop_bill_services[<?php echo $data->id; ?>][shop_service_id]" class="form-control ks-select" data-parent="##parent-select#" style="width: 100%">
            <?php
            $tmp = 'data-id="'.$data->values['shop_service_id'].'"';
            echo str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/service/list/list']);
            ?>
        </select>
    </td>
    <td>
        <input data-id="date" name="shop_bill_services[<?php echo $data->id; ?>][date]" class="form-control" data-type="date" type="datetime" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>">
    </td>
    <td data-id="price"><?php echo Func::getNumberStr($data->values['price'], FALSE); ?></td>
    <td>
        <input data-id="quantity" name="shop_bill_services[<?php echo $data->id; ?>][quantity]" class="form-control" type="text" value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>">
    </td>
    <td data-id="amount" data-amount-tr="<?php echo $data->values['amount']; ?>"><?php echo Func::getNumberStr($data->values['amount'], FALSE); ?></td>
    <td>
        <button type="button" class="close" aria-label="Close" data-action="tr-delete-free">
            <span aria-hidden="true" class="fa fa-close"></span>
        </button>
    </td>
</tr>