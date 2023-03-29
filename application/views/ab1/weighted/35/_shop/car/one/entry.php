<tr id="entry-<?php echo $data->id; ?>" data-name="<?php echo $data->values['name'];?>" data-type="<?php echo $data->values['type'];?>">
    <td><input data-action="auto-number" id="auto-<?php echo $data->id; ?>" data-id="<?php echo $data->id; ?>" name="name" type="text" class="form-control text-number" placeholder="№ авто" style="text-transform: uppercase;"  value="<?php echo htmlspecialchars(Arr::path($data->values, 'name', ''), ENT_QUOTES);?>"></td>
    <td><button onclick="sendTarraForm(<?php echo $data->id; ?>);" class="btn bg-navy btn-flat">В очередь</button></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name', ''); ?></td>
    <td><?php if(Arr::path($data->values['options'], 'is_not_overload', '') == 1){ echo 'не перегружать';}?></td>
</tr>