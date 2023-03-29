<tr class="table__row">
    <td class="table__col"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_parcel_id.tracker', ''); ?></td>
    <td class="table__col"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_parcel_id.amount', ''); ?>$</td>
    <td class="table__col"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_parcel_id.text', ''); ?></td>
    <td class="table__col"><?php if($data->values['is_paid'] == 1){echo 'Оплачено';}else{echo '<a href="#" class="link link--inherit">Оплатить</a>';} ?></td>
</tr>