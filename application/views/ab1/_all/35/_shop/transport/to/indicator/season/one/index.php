<?php $isShow = Request_RequestParams::getParamBoolean('is_show'); ?>
<tr>
    <td>
        <?php echo $data->getElementValue('shop_transport_indicator_id', 'name', $data->values['name']);?>
    </td>
    <?php foreach (Arr::path($data->additionDatas, 'seasons', array()) as $child){?>
    <td>
        <input data-type="money" data-fractional-length="3" name="shop_transport_to_indicator_seasons[<?php echo $data->id; ?>][<?php echo $child['id']; ?>][quantity]" type="phone" class="form-control" value="<?php echo Arr::path($child, 'quantity', '');?>">
    </td>
    <?php } ?>
</tr>