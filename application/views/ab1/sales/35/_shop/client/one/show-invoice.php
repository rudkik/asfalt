<?php if($data->id >0 ){ ?>
<select id="shop_client_id"  class="form-control select2" style="width: 100%" disabled>
    <option value="<?php echo $data->values['id']; ?>"  selected><?php echo $data->values['name']; ?></option>
</select>
<input name="shop_client_id" value="<?php echo $data->values['id']; ?>" style="display: none">
<?php }else{ ?>
    <select id="shop_client_id"  class="form-control select2" style="width: 100%" disabled>
        <option value="0"  selected>Клиент не выбран</option>
    </select>
    <input name="shop_client_id" value="0" style="display: none">
<?php } ?>
