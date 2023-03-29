<?php
$isShow = Request_RequestParams::getParamBoolean('is_show');
?>
<tr>
    <td data-id="name">
        <?php echo $data->getElementValue('shop_transport_work_id', 'name', $data->values['name']); ?>
    </td>
    <td>
        <input name="shop_transport_waybill_work_cars[<?php echo $data->id; ?>][shop_transport_work_id]"
               value="<?php echo Arr::path($data->values, 'shop_transport_work_id', $data->id); ?>" style="display: none">
        <input name="shop_transport_waybill_work_cars[<?php echo $data->id; ?>][shop_transport_id]"
               value="<?php echo $data->values['shop_transport_id']; ?>" style="display: none">
        <input  data-type="money" data-fractional-length="3" data-indicator="<?php echo $data->getElementValue('shop_transport_work_id', 'indicator_type_id', Arr::path($data->values,'indicator_type_id')); ?>"
               data-id="quantity"
               name="shop_transport_waybill_work_cars[<?php echo $data->id; ?>][quantity]"
               type="phone" class="form-control" placeholder="Кол-во"
               value="<?php echo Arr::path($data->values, 'quantity', ''); ?>">
    </td>
</tr>