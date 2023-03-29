<tr>
    <td>
        <select data-id="shop_good_id" name="shop_worker_good_items[<?php echo $data->id; ?>][shop_good_id]" class="form-control ks-select" data-parent="##parent-select#" style="width: 100%">
            <?php
            $tmp = 'data-id="'.Arr::path($data->values, 'shop_good_id', $data->values['id']).'"';
            echo str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/good/list/list']);
            ?>
        </select>
    </td>
    <td data-id="weight">
        <?php echo $data->values['weight']; ?>
    </td>
    <td data-id="price">
        <?php echo Func::getNumberStr(Arr::path($data->values, 'price', Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.price','')), TRUE, 0); ?>
    </td>
    <td>
        <input data-id="took" data-action="total" name="shop_worker_good_items[<?php echo $data->id; ?>][took]" class="form-control money-format" type="text" value="<?php echo  intval(Arr::path($data->values, 'took', '')); ?>">
    </td>
    <td>
        <input data-id="return" data-action="total" name="shop_worker_good_items[<?php echo $data->id; ?>][return]" class="form-control money-format" type="text" value="<?php echo  intval(Arr::path($data->values, 'return', '')); ?>">
    </td>
    <td data-id="quantity">
        <?php echo Arr::path($data->values, 'quantity', ''); ?>
    </td>
    <td data-id="amount"
        data-weight="<?php echo Arr::path($data->values, 'weight', ''); ?>"
        data-amount="<?php echo Arr::path($data->values, 'amount', ''); ?>"
        data-price="<?php echo Arr::path($data->values, 'price', floatval(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.price',''))); ?>">
        <?php echo Func::getNumberStr(Arr::path($data->values, 'amount', '')); ?>
    </td>
    <td>
        <button type="button" class="close" aria-label="Close" data-action="tr-delete">
            <span aria-hidden="true" class="fa fa-close"></span>
        </button>
    </td>
</tr>