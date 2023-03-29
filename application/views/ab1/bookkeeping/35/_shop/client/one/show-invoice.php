<select data-action-select2="1" id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
    <option value="<?php echo $data->values['id']; ?>"  selected><?php echo $data->values['name']; ?></option>
</select>
<input id="shop_client_name" name="shop_client_name" value="<?php echo $data->values['name']; ?>" data-amount="<?php echo $data->values['balance_cache']; ?>" style="display: none">